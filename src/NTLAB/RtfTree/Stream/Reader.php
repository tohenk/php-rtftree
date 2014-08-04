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

namespace NTLAB\RtfTree\Stream;

use NTLAB\RtfTree\Lexer\Char;

class Reader
{
    /**
     * @var string
     */
    protected $char = null;

    /**
     * @var boolean
     */
    protected $eof = null;

    /**
     * Read single character from stream.
     *
     * @param \NTLAB\RtfTree\Stream\Stream $stream
     * @return boolean
     */
    public function read(Stream $stream)
    {
        if (!($this->eof = !$stream->read())) {
            $this->char = $stream->getChar();
        }

        return !$this->eof;
    }

    /**
     * Check if the last read reach end of file.
     *
     * @return boolean
     */
    public function isEof()
    {
        return $this->eof;
    }

    /**
     * Get the last read character.
     *
     * @return string
     */
    public function getChar()
    {
        return $this->char;
    }

    /**
     * Check if current character is a block start.
     *
     * @return boolean
     */
    public function isBlockStart()
    {
        return Char::isBlockStart($this->char);
    }

    /**
     * Check if current character is a block end.
     *
     * @return boolean
     */
    public function isBlockEnd()
    {
        return Char::isBlockEnd($this->char);
    }

    /**
     * Check if current character is a keyword marker.
     *
     * @return boolean
     */
    public function isKeywordMarker()
    {
        return Char::isKeywordMarker($this->char);
    }

    /**
     * Check if current character is a keyword stop.
     *
     * @return boolean
     */
    public function isKeywordStop()
    {
        return Char::isKeywordStop($this->char);
    }

    /**
     * Check if current character is a hex marker.
     *
     * @return boolean
     */
    public function isHexMarker()
    {
        return Char::isHexMarker($this->char);
    }

    /**
     * Check if current character is a whitespace.
     *
     * @return boolean
     */
    public function isWhitespace()
    {
        return Char::isWhitespace($this->char);
    }

    /**
     * Check if current character is a letter.
     *
     * @return boolean
     */
    public function isLetter()
    {
        return Char::isLetter($this->char);
    }

    /**
     * Check if current character is a digit.
     *
     * @return boolean
     */
    public function isDigit()
    {
        return Char::isDigit($this->char);
    }

    /**
     * Check if current character is need escaping.
     *
     * @return boolean
     */
    public function isEscapable()
    {
        return Char::isEscapable($this->char);
    }

    /**
     * Check if current character is need hex escaping.
     *
     * @return boolean
     */
    public function isHexEscapable()
    {
        return Char::isHexEscapable($this->char);
    }

    /**
     * Check if current character is match a character.
     *
     * @return boolean
     */
    public function isChar($ch)
    {
        return $ch == $this->char;
    }

    /**
     * Check if current character is match againt sets of character.
     *
     * @return boolean
     */
    public function inSet($sets = array())
    {
        return in_array($this->char, $sets);
    }
}