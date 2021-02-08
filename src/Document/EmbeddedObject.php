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

use NTLAB\RtfTree\Node\Node;

class EmbeddedObject extends DocObject
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $class;

    protected function init()
    {
        $this->readProp('objw', $this->width);
        $this->readProp('objh', $this->height);
        $this->findChild(['objemb', 'objlink', 'objautlink', 'objsub', 'objpub', 'objicemb',
            'objhtml'], $this->type);
        if ($this->node) {
            // {\*\objclass Paint.Picture}
            if (($node = $this->node->selectSingleNode('objclass')) && ($nextSibling = $node->getNextSibling())) {
                $this->class = $nextSibling->getKey();
            }
            // '{' \object (<objtype> & <objmod>? & <objclass>? & <objname>? & <objtime>? & <objsize>? & <rsltmod>?) ('{\*' \objdata (<objalias>? & <objsect>?) <data> '}') <result> '}'
            if (($node = $this->node->selectSingleNode('objdata')) && ($parent = $node->getParent())) {
                $this->setDataNodes($parent->selectChildNodesTyped(Node::TEXT));
            }
        }
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type.
     *
     * @param string $type  The type
     * @return \NTLAB\RtfTree\Document\EmbeddedObject
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get class.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set class.
     *
     * @param string $class  The class
     * @return \NTLAB\RtfTree\Document\EmbeddedObject
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }
}