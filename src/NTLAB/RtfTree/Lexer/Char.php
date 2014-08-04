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

/**
 * RTF character helper. This class provide utility to read RTF.
 *
 * @author Toha
 */
class Char
{
    const BLOCK_START = '{';
    const BLOCK_END = '}';
    const KEYWORD_MARKER = '\\';
    const KEYWORD_STOP = ' ';
    const HEX_MARKER = '\'';

    /**
     * Is character a block start?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isBlockStart($ch)
    {
        return static::BLOCK_START == $ch;
    }

    /**
     * Is character a block end?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isBlockEnd($ch)
    {
        return static::BLOCK_END == $ch;
    }

    /**
     * Is character a keyword marker?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isKeywordMarker($ch)
    {
        return static::KEYWORD_MARKER == $ch;
    }

    /**
     * Is character a keyword stop?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isKeywordStop($ch)
    {
        return static::KEYWORD_STOP == $ch;
    }

    /**
     * Is character a hex marker?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isHexMarker($ch)
    {
        return static::HEX_MARKER == $ch;
    }

    /**
     * Is character a whitespace?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isWhitespace($ch)
    {
        return in_array($ch, array("\0", "\t", "\r", "\n"));
    }

    /**
     * Is character a letter?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isLetter($ch)
    {
        return preg_match('/[a-zA-Z]/', $ch);
    }

    /**
     * Is character a digit?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isDigit($ch)
    {
        return preg_match('/[0-9]/', $ch);
    }

    /**
     * Is character a need escaping?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isEscapable($ch)
    {
        return in_array($ch, array(static::BLOCK_START, static::BLOCK_END, static::KEYWORD_MARKER));
    }

    /**
     * Is character a need hex escaping?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isHexEscapable($ch)
    {
        return in_array($ch, array(static::HEX_MARKER));
    }

    /**
     * Is character a plain character?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isPlain($ch)
    {
        return preg_match('/[\x20-\x7f]/', $ch);
    }

    /**
     * Is character must be encoded as hex?
     *
     * @param string $ch  The character
     * @return boolean
     */
    public static function isInHex($ch)
    {
        return preg_match('/[\x00-\x1f\x80-\xff]/', $ch);
    }
}