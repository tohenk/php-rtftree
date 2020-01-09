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

use NTLAB\RtfTree\Node\Nodes;

class DocObject
{
    /**
     * @var \NTLAB\RtfTree\Node\Node
     */
    protected $node;

    /**
     * @var string
     */
    protected $hexData;

    /**
     * @var string
     */
    protected $binaryData;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * Constructor.
     *
     * @param \NTLAB\RtfTree\Node\Node $node  The object node
     */
    public function __construct($node)
    {
        $this->node = $node;
        $this->init();
    }

    /**
     * Initialize.
     */
    protected function init()
    {
    }

    /**
     * Get the node.
     *
     * @return \NTLAB\RtfTree\Node\Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Get hex data.
     *
     * @return string
     */
    public function getHexData()
    {
        return $this->hexData;
    }

    /**
     * Get binary data.
     *
     * @return string
     */
    public function getBinaryData()
    {
        return $this->binaryData;
    }

    /**
     * Read node parameter property.
     *
     * @param string $prop  The property name
     * @param int $value  Output value
     * @param int $default  The default value
     * @return boolean
     */
    protected function readProp($prop, &$value, $default = null)
    {
        if ($this->node && ($node = $this->node->selectSingleChildNode($prop))) {
            $value = $node->getParameter();

            return true;
        } else {
            $value = $default;
        }

        return false;
    }

    /**
     * Find matched key of child node.
     *
     * @param array $keys  The node keys
     * @param string $match  Matched node key
     * @return boolean
     */
    protected function findChild($keys, &$match)
    {
        if ($this->node) {
            foreach ($keys as $key) {
                if ($this->node->selectSingleChildNode($key)) {
                    $match = $key;

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Convert data to binary.
     *
     * @param string $data  Hex data
     * @return string
     */
    public function toBin($data)
    {
        return hex2bin($data);
    }

    /**
     * Convert data to hex.
     *
     * @param string $data  Binary data
     * @return string
     */
    public function toHex($data)
    {
        return bin2hex($data);
    }

    /**
     * Get width.
     *
     * @param int Unit type
     * @return float
     */
    public function getWidth($unit = null)
    {
        return null === $unit ? $this->width : Unit::fromNative($unit, $this->width);
    }

    /**
     * Set width.
     *
     * @param float $width  Width
     * @return \NTLAB\RtfTree\Document\DocObject
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get height.
     *
     * @param int Unit type
     * @return float
     */
    public function getHeight($unit = null)
    {
        return null === $unit ? $this->height : Unit::fromNative($unit, $this->height);
    }

    /**
     * Set height.
     *
     * @param float $height  Height
     * @return \NTLAB\RtfTree\Document\DocObject
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Set data from nodes.
     *
     * @param Nodes $nodes
     * @return \NTLAB\RtfTree\Document\DocObject
     */
    protected function setDataNodes(Nodes $nodes)
    {
        if ($nodes) {
            $this->binaryData = null;
            $this->hexData = null;
            foreach ($nodes as $node) {
                $this->hexData .= $node->getKey();
            }
            if ($this->hexData) {
                $this->binaryData = $this->toBin($this->hexData);
            }
        }

        return $this;
    }
}