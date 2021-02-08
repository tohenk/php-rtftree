<?php

/*
 * The MIT License
 *
 * Copyright (c) 2014-2021 Toha <tohenk@yahoo.com>
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

namespace NTLAB\RtfTree\Tokenizer;

use NTLAB\RtfTree\Common\Char;

class TokenizerRe extends Tokenizer
{
    /**
     * Parse keyword token.
     *
     * @param \NTLAB\RtfTree\Tokenizer\Token $token  The result token
     * @return \NTLAB\RtfTree\Tokenizer\TokenizerRe
     */
    protected function parseKeyword(Token $token)
    {
        $type = null;
        $parameter = null;
        switch (true) {
            case null !== ($key = $this->reader->expect(sprintf('[%s]', $this->escape([Char::BLOCK_START, Char::BLOCK_END, Char::KEYWORD_MARKER])))):
                $type = Token::TEXT;
                break;
            case null !== ($key = $this->reader->expect('[a-zA-Z]+')):
                $type = Token::KEYWORD;
                $parameter = $this->reader->expect('(\-)*([0-9]+)');
                // skip keyword separator
                $this->reader->expect($this->escape(Char::KEYWORD_STOP));
                break;
            case null !== ($key = $this->reader->expect($this->escape(Char::HEX_MARKER))):
                if (null !== ($parameter = $this->reader->expect('[0-9a-fA-F]{2}'))) {
                    $type = Token::CONTROL;
                    $parameter = hexdec($parameter);
                }
                break;
            case null !== ($key = $this->reader->expect($this->escape('*'))):
                $type = Token::CONTROL;
                break;
        }
        if (null !== $type) {
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
     * Get the next token.
     *
     * @return \NTLAB\RtfTree\Tokenizer\Token
     */
    public function nextToken()
    {
        if (!$this->reader->getStream()->available()) {
            return;
        }
        $token = new Token();
        switch (true) {
            case null !== ($match = $this->reader->expect($this->escape(Char::BLOCK_START))):
                $token->setType(Token::GROUP_START);
                break;
            case null !== ($match = $this->reader->expect($this->escape(Char::BLOCK_END))):
                $token->setType(Token::GROUP_END);
                break;
            case null !== ($match = $this->reader->expect($this->escape(Char::KEYWORD_MARKER))):
                $this->parseKeyword($token);
                break;
            case null !== ($match = $this->reader->expect(sprintf('[%s]+', $this->escape(Char::getWhitespaces())))):
                $token->setType(Token::WHITESPACE);
                $token->setKey($match);
                break;
            default:
                if (null !== ($match = $this->reader->expect(sprintf('[^%s]+', $this->escape(array_merge([Char::BLOCK_START, Char::BLOCK_END, Char::KEYWORD_MARKER], Char::getWhitespaces())))))) {
                    $token->setType(Token::TEXT);
                    $token->setKey($match);
                }
                break;
        }
        return $token;
    }

    /**
     * Get escaped text of regular expression character.
     *
     * @param string $chars  The character
     * @return string
     */
    protected function escape($chars)
    {
        $result = null;
        $chars = !is_array($chars) ? [$chars] : $chars;
        foreach ($chars as $ch) {
            if (in_array($ch, [
                '/', '\\', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '[', ']',
                '{', '}', '-', '+', '=', '.', '?', ',', ':', '<', '>', '\'', '"',
            ])) {
                $ch = '\\'.$ch;
            }
            $ch = strtr($ch, ["\0" => '\\0', "\t" => '\\t', "\r" => '\\r', "\n" => '\\n', ' ' => '\x20']);
            $result .= $ch;
        }
        return $result;
    }
}