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

namespace NTLAB\RtfTree\Encoding;

use NTLAB\RtfTree\Common\HexUtil;

class Encoding
{
    protected static $instance = null;

    /**
     * Create encoding instance.
     *
     * @return \NTLAB\RtfTree\Encoding\Encoding
     */
    public static function create()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get character code.
     *
     * @param string $char  The character
     * @return int
     */
    public static function getCode($char)
    {
        if (count($codes = explode(' ', trim(strtr(json_encode($char), ['"' => '', '\u' => ' ']))))) {
            return hexdec($codes[0]);
        }
    }

    /**
     * Convert character code to character.
     *
     * @param int $code  The character code
     * @return string
     */
    public static function getChar($code)
    {
        $char = json_decode(sprintf('"\u%s"', HexUtil::toHex($code, 4)));
        return $char;
    }

    /**
     * Encode a character to code.
     *
     * @param string $char  The character to encode
     * @return int
     */
    public function encode($char)
    {
        return $this->getCode($char);
    }

    /**
     * Decode a character code into a string.
     *
     * @param int $code  Character code to decode
     * @return string
     */
    public function decode($code)
    {
        return $this->getChar($code);
    }
}