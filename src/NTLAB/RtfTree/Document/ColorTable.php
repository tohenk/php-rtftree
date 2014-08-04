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
use NTLAB\RtfTree\Node\Nodes;

class ColorTable
{
    /**
     * @var \NTLAB\RtfTree\Document\Color
     */
    protected $color;

    /**
     * Constructor.
     *
     * @param int $rgb  The color RGB
     */
    public function __construct($rgb = null)
    {
        $this->color = new Color();
        if ($rgb) {
            $this->color->setValue($rgb);
        }
    }

    /**
     * Get the color.
     *
     * @return \NTLAB\RtfTree\Document\Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Create tree nodes.
     *
     * @return \NTLAB\RtfTree\Node\Nodes
     */
    public function createNodes()
    {
        $nodes = new Nodes();
        $nodes[] = Node::create(Node::KEYWORD, 'red', true, $this->color->getR());
        $nodes[] = Node::create(Node::KEYWORD, 'green', true, $this->color->getG());
        $nodes[] = Node::create(Node::KEYWORD, 'blue', true, $this->color->getB());
        $nodes[] = Node::create(Node::TEXT, ';');

        return $nodes;
    }

    /**
     * Extract color table information from color table group.
     *
     * @param \NTLAB\RtfTree\Node\Node $node  The color table group node
     * @return array
     */
    public static function extract(Node $node)
    {
        $colors = array();
        $color = 0;
        $nodes = array();
        foreach ($node->getChildren() as $child) {
            if ($child->is(Node::KEYWORD)) {
                if ($child->isEquals('red')) {
                    Color::R($color, $child->getParameter());
                    $nodes[] = $child;
                }
                if ($child->isEquals('green')) {
                    Color::G($color, $child->getParameter());
                    $nodes[] = $child;
                }
                if ($child->isEquals('blue')) {
                    Color::B($color, $child->getParameter());
                    $nodes[] = $child;
                }
                continue;
            }
            if ($child->isEquals(';')) {
                $nodes[] = $child;
                $colors[] = array($color, $nodes);
                $color = 0;
                $nodes = array();
                continue;
            }
        }

        return $colors;
    }
}