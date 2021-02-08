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

namespace NTLAB\RtfTree\Document;

class Paragraph
{
    const ALIGN_LEFT = 1;
    const ALIGN_CENTER = 2;
    const ALIGN_RIGHT = 3;
    const ALIGN_JUSTIFY = 4;

    /**
     * @var int
     */
    protected $alignment = self::ALIGN_LEFT;

    /**
     * @var int
     */
    protected $indent;

    /**
     * @var int
     */
    protected $leftIndent;

    /**
     * @var int
     */
    protected $rightIndent;

    protected static $keywords = [
        self::ALIGN_LEFT    => 'ql',
        self::ALIGN_CENTER  => 'qc',
        self::ALIGN_RIGHT   => 'qr',
        self::ALIGN_JUSTIFY => 'qj',
    ];

    /**
     * Get paragraph alignment keyword.
     *
     * @param int $alignment  Paragraph alignment
     * @return string
     */
    public static function getKeyword($alignment)
    {
        return self::$keywords[$alignment];
    }

    /**
     * Check if aligmnent is matched.
     *
     * @param int $alignment  The alignment
     * @return boolean
     */
    public function is($alignment)
    {
        return $this->alignment === $alignment;
    }

    /**
     * Get alignment.
     *
     * @return int
     */
    public function getAlignment()
    {
        return $this->alignment;
    }

    /**
     * Set alignment.
     *
     * @param int $alignment  The alignment
     * @return \NTLAB\RtfTree\Document\Paragraph
     */
    public function setAlignment($alignment)
    {
        $this->alignment = $alignment;
        return $this;
    }

    /**
     * Get paragraph indentation.
     *
     * @param int Unit type
     * @return float
     */
    public function getIndent($unit = null)
    {
        return null === $unit ? $this->indent : Unit::fromNative($unit, $this->indent);
    }

    /**
     * Set indent.
     *
     * @param int $indent  The indent
     * @return \NTLAB\RtfTree\Document\Paragraph
     */
    public function setIndent($indent)
    {
        $this->indent = $indent;
        return $this;
    }

    /**
     * Get paragraph left indentation.
     *
     * @param int Unit type
     * @return float
     */
    public function getLeftIndent($unit = null)
    {
        return null === $unit ? $this->leftIndent : Unit::fromNative($unit, $this->leftIndent);
    }

    /**
     * Set paragraph left indentation.
     *
     * @param int $leftIndent  Paragraph left indentation
     * @return \NTLAB\RtfTree\Document\Paragraph
     */
    public function setLeftIndent($leftIndent)
    {
        $this->leftIndent = $leftIndent;
        return $this;
    }

    /**
     * Get paragraph right indentation.
     *
     * @param int Unit type
     * @return float
     */
    public function getRightIndent($unit = null)
    {
        return null === $unit ? $this->rightIndent : Unit::fromNative($unit, $this->rightIndent);
    }

    /**
     * Set paragraph right indentation.
     *
     * @param int $rightIndent  Paragraph right indentation
     * @return \NTLAB\RtfTree\Document\Paragraph
     */
    public function setRightIndent($rightIndent)
    {
        $this->rightIndent = $rightIndent;
        return $this;
    }

    /**
     * Clear paragraph attributes.
     *
     * @return \NTLAB\RtfTree\Document\Paragraph
     */
    public function clear()
    {
        $this->alignment = static::ALIGN_LEFT;
        $this->indent = null;
        $this->leftIndent = null;
        $this->rightIndent = null;
        return $this;
    }
}