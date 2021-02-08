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

class PageSetup
{
    /**
     * @var \NTLAB\RtfTree\Document\Document
     */
    protected $document;

    /**
     * @var float
     */
    protected $width;

    /**
     * @var float
     */
    protected $height;

    /**
     * @var float
     */
    protected $marginTop;

    /**
     * @var float
     */
    protected $marginBottom;

    /**
     * @var float
     */
    protected $marginLeft;

    /**
     * @var float
     */
    protected $marginRight;

    /**
     * Constructor.
     *
     * @param \NTLAB\RtfTree\Document\Document $document Owner document
     */
    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * Get page width.
     *
     * @param int Unit type
     * @return float
     */
    public function getWidth($unit = null)
    {
        return null === $unit ? $this->width : Unit::fromNative($unit, $this->width);
    }

    /**
     * Set page width.
     *
     * @param float $width  Page width
     * @return \NTLAB\RtfTree\Document\PageSetup
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Get page height.
     *
     * @param int Unit type
     * @return float
     */
    public function getHeight($unit = null)
    {
        return null === $unit ? $this->height : Unit::fromNative($unit, $this->height);
    }

    /**
     * Set page height.
     *
     * @param float $height  Page height
     * @return \NTLAB\RtfTree\Document\PageSetup
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Get page margin top.
     *
     * @param int Unit type
     * @return float
     */
    public function getMarginTop($unit = null)
    {
        return null === $unit ? $this->marginTop : Unit::fromNative($unit, $this->marginTop);
    }

    /**
     * Set page margin top.
     *
     * @param float $marginTop  Page margin top
     * @return \NTLAB\RtfTree\Document\PageSetup
     */
    public function setMarginTop($marginTop)
    {
        $this->marginTop = $marginTop;
        return $this;
    }

    /**
     * Get page margin bottom.
     *
     * @param int Unit type
     * @return float
     */
    public function getMarginBottom($unit = null)
    {
        return null === $unit ? $this->marginBottom : Unit::fromNative($unit, $this->marginBottom);
    }

    /**
     * Set page margin bottom.
     *
     * @param float $marginBottom  Page margin bottom
     * @return \NTLAB\RtfTree\Document\PageSetup
     */
    public function setMarginBottom($marginBottom)
    {
        $this->marginBottom = $marginBottom;
        return $this;
    }

    /**
     * Get page margin left.
     *
     * @param int Unit type
     * @return float
     */
    public function getMarginLeft($unit = null)
    {
        return null === $unit ? $this->marginLeft : Unit::fromNative($unit, $this->marginLeft);
    }

    /**
     * Set page margin left.
     *
     * @param float $marginLeft  Page margin left
     * @return \NTLAB\RtfTree\Document\PageSetup
     */
    public function setMarginLeft($marginLeft)
    {
        $this->marginLeft = $marginLeft;
        return $this;
    }

    /**
     * Get page margin right.
     *
     * @param int Unit type
     * @return float
     */
    public function getMarginRight($unit = null)
    {
        return null === $unit ? $this->marginRight : Unit::fromNative($unit, $this->marginRight);
    }

    /**
     * Set page margin right.
     *
     * @param float $marginRight  Page margin right
     * @return \NTLAB\RtfTree\Document\PageSetup
     */
    public function setMarginRight($marginRight)
    {
        $this->marginRight = $marginRight;
        return $this;
    }

    /**
     * Clear all properties.
     *
     * @return \NTLAB\RtfTree\Document\PageSetup
     */
    public function clear()
    {
        foreach (['width', 'height', 'marginTop', 'marginBottom', 'marginLeft', 'marginRight'] as $var) {
            $this->$var = null;
        }
        return $this;
    }
}