<?php

/*
 * The MIT License
 *
 * Copyright (c) 2014 Toha <tohenk@yahoo.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace NTLAB\RtfTree\Lexer;

use NTLAB\RtfTree\Stream\Stream;
use NTLAB\RtfTree\Stream\Reader;

class Lexer
{
    /**
     * @var \NTLAB\RtfTree\Stream\Stream
     */
    protected $stream;

    /**
     * @var \NTLAB\RtfTree\Stream\Reader
     */
    protected $reader;

    /**
     * Constructor.
     *
     * @param \NTLAB\RtfTree\Stream\Stream $stream  Source stream
     */
    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
        $this->reader = new Reader();
    }

    /**
     * Read stream.
     *
     * @return boolean
     */
    protected function read()
    {
        return $this->reader->read($this->stream);
    }

    /**
     * Move stream position to the previous one.
     *
     * @return \NTLAB\RtfTree\Lexer\Lexer
     */
    protected function prev()
    {
        $this->stream->prev();

        return $this;
    }

    /**
     * Move stream position to the next one.
     * @return \NTLAB\RtfTree\Lexer\Lexer
     */
    protected function next()
    {
        $this->stream->next();

        return $this;
    }

    /**
     * Parse whitespace token.
     *
     * @param \NTLAB\RtfTree\Lexer\Token $token  The result token
     * @return \NTLAB\RtfTree\Lexer\Lexer
     */
    protected function parseWhitespace(Token $token)
    {
        $key = null;
        while (true) {
            $key .= $this->reader->getChar();
            if (!$this->read() || !$this->reader->isWhitespace()) {
                break;
            }
        }
        if (!$this->reader->isEof()) {
            $this->prev();
        }
        $token->setType(Token::WHITESPACE);
        $token->setKey($key);

        return $this;
    }

    /**
     * Parse keyword token.
     *
     * @param \NTLAB\RtfTree\Lexer\Token $token  The result token
     * @return \NTLAB\RtfTree\Lexer\Lexer
     */
    protected function parseKeyword(Token $token)
    {
        // Pick one character
        if ($this->read()) {
            $key = null;
            $parameter = null;
            // is escape sequence for {, }, and \
            if ($this->reader->isEscapable()) {
                $type = Token::TEXT;
                $key = $this->reader->getChar();
            // is letter
            } else if ($this->reader->isLetter()) {
                $type = Token::KEYWORD;
                while (true) {
                    $key .= $this->reader->getChar();
                    if (!$this->read() || !$this->reader->isLetter()) {
                        break;
                    }
                }
                // pick for keyword parameter, allow minus sign too
                if (!$this->reader->isEof() && ($this->reader->isDigit() || $this->reader->isChar('-'))) {
                    while (true) {
                        $parameter .= $this->reader->getChar();
                        if (!$this->read() || (!$this->reader->isDigit() && !$this->reader->isChar('-'))) {
                            break;
                        }
                    }
                }
                // move back one character
                if (!$this->reader->isEof() && !$this->reader->isKeywordStop()) {
                    $this->prev();
                }
            } else {
                $type = Token::CONTROL;
                $key = $this->reader->getChar();
                // is hexa character
                if ($this->reader->isHexEscapable()) {
                    $count = 2;
                    while ($count > 0) {
                        if (!$this->read()) {
                            break;
                        }
                        $parameter .= $this->reader->getChar();
                        $count--;
                    }
                    $parameter = 2 === strlen($parameter) ? hexdec($parameter) : null;
                }
            }
            $token->setType($type);
            $token->setKey($key);
            if (null !== $parameter) {
                $token->setHasParameter(true);
                $token->setParameter((int) $parameter);
            }
        }

        return $this;
    }

    /**
     * Parse text token.
     *
     * @param \NTLAB\RtfTree\Lexer\Token $token  The result token
     * @return \NTLAB\RtfTree\Lexer\Lexer
     */
    protected function parseText(Token $token)
    {
        $key = null;
        while (true) {
            $key .= $this->reader->getChar();
            if (!$this->read() || $this->reader->isEscapable() || $this->reader->isWhitespace()) {
                break;
            }
        }
        if (!$this->reader->isEof()) {
            $this->prev();
        }
        $token->setType(Token::TEXT);
        $token->setKey($key);

        return $this;
    }

    /**
     * Get the next token.
     *
     * @return \NTLAB\RtfTree\Lexer\Token
     */
    public function nextToken()
    {
        $token = new Token();
        if ($this->read()) {
            if ($this->reader->isBlockStart()) {
                $token->setType(Token::GROUP_START);
            } else if ($this->reader->isBlockEnd()) {
                $token->setType(Token::GROUP_END);
            } else if ($this->reader->isWhitespace()) {
                $this->parseWhitespace($token);
            } else if ($this->reader->isKeywordMarker()) {
                $this->parseKeyword($token);
            } else {
                $this->parseText($token);
            }
        } else {
            $token->setType(Token::EOF);
        }

        return $token;
    }

    /**
     * Get input stream.
     *
     * @return \NTLAB\RtfTree\Stream\Stream
     */
    public function getStream()
    {
        return $this->stream;
    }
}