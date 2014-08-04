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

namespace NTLAB\RtfTree\Node;

use NTLAB\RtfTree\Common\Collection;

class Nodes extends Collection
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->reorder = true;
        $this->itemClass = Node::class;
    }

    /**
     * Get child node index by its key.
     *
     * @param string $key  Node key
     * @param int $startIndex  The start index
     * @return int
     */
    public function getIndex($key, $startIndex = 0)
    {
        for ($i = max(array(0, $startIndex)); $i < count($this->items); $i++) {
            $node = $this->items[$i];
            if ($node instanceof Node && $node->isEquals($key)) {
                return $i;
            }
        }
    }
}