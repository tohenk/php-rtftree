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

namespace NTLAB\RtfTree\Document;

use NTLAB\RtfTree\Node\Node;

class FontTable
{
    const FONT_FAM_NIL = 'nil';
    const FONT_FAM_ROMAN = 'roman';
    const FONT_FAM_SWISS = 'swiss';
    const FONT_FAM_MODERN = 'modern';
    const FONT_FAM_SCRIPT = 'script';
    const FONT_FAM_DECOR = 'decor';
    const FONT_FAM_TECH = 'tech';
    const FONT_FAM_BIDI = 'bidi';

    /**
     * @var int
     */
    protected $index;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $families = array();

    /**
     * @var int
     */
    protected $charset;

    /**
     * @var int
     */
    protected $pitch;

    /**
     * Constructor.
     *
     * @param int $index  The font index
     * @param string $name  The font name
     */
    public function __construct($index, $name)
    {
        $this->index = $index;
        $this->name = $name;
    }

    /**
     * Get font index.
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Set font index.
     *
     * @param int $index  The index
     * @return \NTLAB\RtfTree\Document\FontTable
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
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
     * @param string $name  The name
     * @return \NTLAB\RtfTree\Document\FontTable
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get font families.
     *
     * @return array
     */
    public function getFamilies()
    {
        return $this->families;
    }

    /**
     * Add font family.
     *
     * @param string $family  The font family
     * @return \NTLAB\RtfTree\Document\FontTable
     */
    public function addFamily($family)
    {
        if (!in_array($family, $this->families)) {
            $this->families[] = $family;
        }

        return $this;
    }

    /**
     * Get font charset.
     *
     * @return int
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Set font charset.
     *
     * @param int $charset  The charset
     * @return \NTLAB\RtfTree\Document\FontTable
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Get font pitch.
     *
     * @return int
     */
    public function getPitch()
    {
        return $this->pitch;
    }

    /**
     * Set font pitch.
     *
     * @param int $pitch  The pitch
     * @return \NTLAB\RtfTree\Document\FontTable
     */
    public function setPitch($pitch)
    {
        $this->pitch = $pitch;

        return $this;
    }

    /**
     * Create tree node.
     *
     * @return \NTLAB\RtfTree\Node\Node
     */
    public function createNode()
    {
        $node = Node::createTyped(Node::GROUP);
        $node->appendChild(Node::create(Node::KEYWORD, 'f', true, $this->index));
        foreach (count($this->families) ? $this->families : array(static::FONT_FAM_NIL) as $family) {
            $node->appendChild(Node::create(Node::KEYWORD, 'f'.$family));
        }
        if (null !== $this->charset) {
            $node->appendChild(Node::create(Node::KEYWORD, 'fcharset', true, $this->charset));
        }
        if (null !== $this->pitch) {
            $node->appendChild(Node::create(Node::KEYWORD, 'fprq', true, $this->pitch));
        }
        $node->appendChild(Node::create(Node::TEXT, $this->name.';'));

        return $node;
    }

    /**
     * Detect font families.
     *
     * @return \NTLAB\RtfTree\Document\FontTable
     */
    public function detectFamilies()
    {
        foreach (array(
            'times new roman'   => static::FONT_FAM_ROMAN,
            'arial'             => static::FONT_FAM_SWISS,
            'courier new'       => static::FONT_FAM_MODERN,
            'cursiva'           => static::FONT_FAM_SCRIPT,
            'symbol'            => static::FONT_FAM_TECH,
            'arabic'            => static::FONT_FAM_BIDI,
        ) as $font => $fam) {
            if (false !== strpos(strtolower($this->name), $font)) {
                $this->addFamily($fam);
            }
        }

        return $this;
    }

    /**
     * Create font table from array.
     *
     * @param array $array  Font table descriptor
     * @return \NTLAB\RtfTree\Document\FontTable
     */
    public static function create($array = array())
    {
        if (is_array($array) && count($array) > 1) {
            $fontTable = new self($array[0], $array[1]);
            // font family
            if (count($array) > 2 && is_array($array[2])) {
                foreach ($array[2] as $family) {
                    $fontTable->addFamily($family);
                }
            }
            // font charset
            if (count($array) > 3 && null !== $array[3]) {
                $fontTable->setCharset($array[3]);
            }
            // font pitch
            if (count($array) > 4 && null !== $array[4]) {
                $fontTable->setPitch($array[4]);
            }

            return $fontTable;
        }
    }

    /**
     * Extract font information from font table group node.
     *
     * @param \NTLAB\RtfTree\Node\Node $node  The font table group node
     * @return array
     */
    public static function extract(Node $node)
    {
        $fName = null;
        $fIndex = null;
        $fFamilies = null;
        $fCharset = null;
        $fPitch = null;
        foreach ($node->getChildren() as $cnode) {
            if ($cnode->isEquals('f')) {
                $fIndex = $cnode->getParameter();
                continue;
            }
            if ('f' === substr($cnode->getKey(), 0, 1)) {
                $fType = substr($cnode->getKey(), 1);
                if ($cnode->hasParameter()) {
                    switch ($fType) {
                        case 'charset':
                            $fCharset = $cnode->getParameter();
                            break;

                        case 'prq':
                            $fPitch = $cnode->getParameter();
                            break;
                    }
                } else {
                    if (null === $fFamilies) {
                        $fFamilies = array();
                    }
                    if (!in_array($fType, $fFamilies)) {
                        $fFamilies[] = $fType;
                    }
                }
                continue;
            }
            if ($cnode->is(Node::TEXT)) {
                $fName = substr($cnode->getKey(), 0, -1);
                continue;
            }
        }
        if (null !== $fName) {
            return array($fIndex, $fName, $fFamilies, $fCharset, $fPitch);
        }
    }
}