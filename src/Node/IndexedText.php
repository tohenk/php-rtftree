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

namespace NTLAB\RtfTree\Node;

class IndexedText
{
    /**
     * @var string
     */
    protected $text = null;

    /**
     * @var array
     */
    protected $indexes = [];

    /**
     * Add text.
     *
     * @param string $text  Text to add
     * @param \NTLAB\RtfTree\Node\Node $node  Owner node
     * @return \NTLAB\RtfTree\Node\IndexedText
     */
    public function add($text, Node $node)
    {
        if (strlen($text)) {
            $position = mb_strlen($this->text);
            $this->indexes[$position] = [mb_strlen($text), $node];
            $this->text .= $text;
        }
        return $this;
    }

    /**
     * Get nodes at position.
     *
     * @param int $start  Start position
     * @param int $end  End position
     * @param string $text Reference text
     * @param int $relPos Relative position of the first matched node
     * @return \NTLAB\RtfTree\Node\Nodes
     */
    protected function getNodes($start, $end, $text, &$relPos)
    {
        $nodes = new Nodes();
        $found = null;
        foreach ($this->indexes as $pos => $data) {
            list($len, $node) = $data;
            if (null === $found) {
                if ($start >= $pos && $start <= $pos + $len - 1) {
                    $found = true;
                    $relPos = $start - $pos;
                }
            }
            if ($found) {
                if ($node->is(Node::GROUP) && $node->containsText($text)) {
                    foreach ($node->getChildren() as $cnode) {
                        if ($cnode->containsText($text)) {
                            $node = $cnode;
                            break;
                        }
                    }
                }
                $nodes[] = $node;
                if ($end >= $pos && $end <= $pos + $len - 1) {
                    break;
                }
            }
        }
        return $nodes;
    }

    /**
     * Find all nodes matched text.
     *
     * @param string $text  The text to find
     * @param int $pos  Matched position
     * @return \NTLAB\RtfTree\Node\Nodes
     */
    public function find($text, &$relPos)
    {
        if (false !== ($pos = mb_strpos($this->text, $text))) {
            return $this->getNodes($pos, $pos + mb_strlen($text) - 1, $text, $relPos);
        }
    }

    public function __toString()
    {
        return null !== $this->text ? $this->text : '';
    }
}