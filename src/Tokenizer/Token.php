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

namespace NTLAB\RtfTree\Tokenizer;

use NTLAB\RtfTree\Common\Base;
use NTLAB\RtfTree\Common\Char;

/**
 * Rtf character tokenizer helper.
 * 
 * Recoqnized token are:
 *   NONE           Token is not defined
 *   KEYWORD        Token is RTF keyword
 *   CONTROL        Token is RTF control
 *   TEXT           Token is text
 *   GROUP_START    Token is group start
 *   GROUP_END      Token is group end
 *   WHITESPACE     Token is whitespace
 *
 * @author Toha
 */
class Token extends Base
{
    const NONE = 0;
    const KEYWORD = 1;
    const CONTROL = 2;
    const TEXT = 3;
    const GROUP_START = 4;
    const GROUP_END = 5;
    const WHITESPACE = 6;

    /**
     * @var array
     */
    protected static $tokenTypes = array(
        self::NONE          => 'NONE',
        self::KEYWORD       => 'KEYWORD',
        self::CONTROL       => 'CONTROL',
        self::TEXT          => 'TEXT',
        self::GROUP_START   => 'GROUP_START',
        self::GROUP_END     => 'GROUP_END',
        self::WHITESPACE    => 'WHITESPACE',
    );

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->type = static::NONE;
    }

    /**
     * Is token assumed as text, e.q. Hex coded text.
     *
     * @return boolean
     */
    public function isText()
    {
        return $this->is(static::CONTROL) && $this->isEquals(Char::HEX_MARKER);
    }

    /**
     * (non-PHPdoc)
     * @see \NTLAB\RtfTree\Common\Base::getTypeText()
     */
    public function getTypeText()
    {
        return self::$tokenTypes[$this->type];
    }
}