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

class Font
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \NTLAB\RtfTree\Document\Color
     */
    protected $color;

    /**
     * @var float
     */
    protected $size;

    /**
     * @var boolean
     */
    protected $bold;

    /**
     * @var boolean
     */
    protected $italic;

    /**
     * @var boolean
     */
    protected $underline;

    /**
     * @var boolean
     */
    protected $strikethrough;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->color = new Color();
    }

    /**
     * Get font name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set font name.
     *
     * @param string $name  Font name
     * @return \NTLAB\RtfTree\Document\Font
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get font color.
     *
     * @return \NTLAB\RtfTree\Document\Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set font color.
     *
     * @return \NTLAB\RtfTree\Document\Font
     */
    public function setColor($color)
    {
        $this->color->setValue($color);
        return $this;
    }

    /**
     * Get font size.
     *
     * @return float
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set font size.
     *
     * @param float $size  Font size
     * @return \NTLAB\RtfTree\Document\Font
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Get font bold.
     *
     * @return boolean
     */
    public function getBold()
    {
        return $this->bold;
    }

    /**
     * Set font bold.
     *
     * @param boolean $bold  Font bold
     * @return \NTLAB\RtfTree\Document\Font
     */
    public function setBold($bold)
    {
        $this->bold = $bold;
        return $this;
    }

    /**
     * Get font italic.
     *
     * @return boolean
     */
    public function getItalic()
    {
        return $this->italic;
    }

    /**
     * Set font italic.
     *
     * @param boolean $italic  Font italic
     * @return \NTLAB\RtfTree\Document\Font
     */
    public function setItalic($italic)
    {
        $this->italic = $italic;
        return $this;
    }

    /**
     * Get font underline.
     *
     * @return boolean
     */
    public function getUnderline()
    {
        return $this->underline;
    }

    /**
     * Set font underline.
     *
     * @param boolean $underline  Font underline
     * @return \NTLAB\RtfTree\Document\Font
     */
    public function setUnderline($underline)
    {
        $this->underline = $underline;
        return $this;
    }

    /**
     * Get font strikethrough.
     *
     * @return boolean
     */
    public function getStrikethrough()
    {
        return $this->strikethrough;
    }

    /**
     * Set font strikethrough.
     *
     * @param boolean $strikethrough  Font strikethrough
     * @return \NTLAB\RtfTree\Document\Font
     */
    public function setStrikethrough($strikethrough)
    {
        $this->strikethrough = $strikethrough;
        return $this;
    }

    /**
     * Assign font.
     *
     * @param \NTLAB\RtfTree\Document\Font $font  Original font
     * @return \NTLAB\RtfTree\Document\Font
     */
    public function assign(Font $font)
    {
        foreach (['name', 'color', 'size', 'bold', 'italic', 'underline', 'strikethrough'] as $var) {
            $value = $font->$var;
            if (is_object($value)) {
                $this->$var->assign($value);
            } else {
                $this->$var = $value;
            }
        }
        return $this;
    }
}