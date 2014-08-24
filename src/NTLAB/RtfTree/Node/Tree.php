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

use NTLAB\RtfTree\Stream\Stream;
use NTLAB\RtfTree\Lexer\Lexer;
use NTLAB\RtfTree\Lexer\Token;
use NTLAB\RtfTree\Lexer\Char;

class Tree
{
    const NAME = 'PHP RtfTree';
    const VERSION = '1.0.0';

    /**
     * @var \NTLAB\RtfTree\Node\Node
     */
    protected $root;

    /**
     * @var \NTLAB\RtfTree\Stream\Stream
     */
    protected $source;

    /**
     * @var \NTLAB\RtfTree\Lexer\Lexer
     */
    protected $lexer;

    /**
     * @var int
     */
    protected $level;

    /**
     * @var boolean
     */
    protected $mergeSpecial = false;

    /**
     * @var boolean
     */
    protected $ignoreWhitespace = true;

    /**
     * @var boolean
     */
    protected $ignoreMalformed = false;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->root = Node::create(Node::ROOT, 'ROOT');
    }

    /**
     * Get root node.
     *
     * @return \NTLAB\RtfTree\Node\Node
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Get main group node.
     *
     * @return \NTLAB\RtfTree\Node\Node
     */
    public function getMainGroup()
    {
        if ($this->root->hasChildNodes()) {
            return $this->root->getFirstChild();
        }
    }

    /**
     * Is merge special enabled.
     *
     * @return boolean
     */
    public function getMergeSpecial()
    {
        return $this->mergeSpecial;
    }

    /**
     * Set merge special.
     *
     * @param boolean $value  Merge special
     * @return \NTLAB\RtfTree\Node\Tree
     */
    public function setMergeSpecial($value)
    {
        $this->mergeSpecial = (bool) $value;

        return $this;
    }

    /**
     * Is ignore whitespace enabled.
     *
     * @return boolean
     */
    public function getIgnoreWhitespace()
    {
        return $this->ignoreWhitespace;
    }

    /**
     * Set ignore whitespace.
     *
     * @param boolean $value  Ignore whitespace
     * @return \NTLAB\RtfTree\Node\Tree
     */
    public function setIgnoreWhitespace($value)
    {
        $this->ignoreWhitespace = (bool) $value;

        return $this;
    }

    /**
     * Is ignore malformed enabled.
     *
     * @return boolean
     */
    public function getIgnoreMalformed()
    {
        return $this->ignoreMalformed;
    }

    /**
     * Set ignore malformed.
     *
     * @param boolean $value  Ignore malformed
     * @return \NTLAB\RtfTree\Node\Tree
     */
    public function setIgnoreMalformed($value)
    {
        $this->ignoreMalformed = (bool) $value;

        return $this;
    }

    /**
     * Add tree main group.
     *
     * @return \NTLAB\RtfTree\Node\Tree
     */
    public function addMainGroup()
    {
        if (!$this->root->hasChildNodes()) {
            $this->root->appendChild(Node::createTyped(Node::GROUP));
        }

        return $this;
    }

    /**
     * Get tree node as plain text.
     *
     * @return string
     */
    public function getText()
    {
        $result = null;
        if (($firstChild = $this->root->getFirstChild()) && ($node = $firstChild->selectSingleChildNode('pard'))) {
            for ($i = $node->getNodeIndex(); $i < count($firstChild->getChildren()); $i++) {
                $result .= $firstChild->getChildAt($i)->getPlainText();
            }
        }

        return $result;
    }

    /**
     * Get rich text representation of the tree.
     *
     * @return string
     */
    public function getRtf()
    {
        return $this->root->getRtf();
    }

    /**
     * Clone current tree.
     *
     * @return \NTLAB\RtfTree\Node\Tree
     */
    public function cloneTree()
    {
        $tree = new self();
        $tree->mergeSpecial = $this->mergeSpecial;
        $tree->ignoreWhitespace = $this->ignoreWhitespace;
        foreach ($this->root->getChildren() as $child) {
            $tree->root->appendChild($child->cloneNode());
        }

        return $tree;
    }

    /**
     * Force token as text token.
     *
     * @param \NTLAB\RtfTree\Lexer\Token $token  The token
     * @return boolean
     */
    protected function forceTokenAsText(Token $token)
    {
        if ($token->isText()) {
            $token->setType(Token::TEXT);
            $token->setKey(Node::decode($token->getParameter()));
            $token->setHasParameter(false);

            return true;
        }

        return false;
    }

    /**
     * Try merge text nodes.
     *
     * @param \NTLAB\RtfTree\Node\Node $node  The merged node
     * @param \NTLAB\RtfTree\Lexer\Token $token  Token to merge
     * @param boolean $deep
     * @return boolean
     */
    protected function tryMergeText(Node $node, Token $token, $deep = true)
    {
        if (!$deep) {
            // do not merge escapable char {, }, and \
            if ($token->is(Token::TEXT) && Char::isEscapable($token->getKey())) {
                return false;
            }
            // do not merge hex coded text
            if ($token->isText()) {
                return false;
            }
        }
        if ($token->is(Token::TEXT) || $token->isText()) {
            if (($cnode = $node->getLastChild()) && $cnode->is(Node::TEXT)) {
                // do not merge if previous node is an escapable char {, }, and \
                if (!$deep && Char::isEscapable($cnode->getKey())) {
                    return false;
                }
                $this->forceTokenAsText($token);
                $cnode->setKey($cnode->getKey().$token->getKey());

                return true;
            }
        }

        return false;
    }

    /**
     * Parse tree. The return value can be processed as follow:
     *   * FALSE -> the source is malformed
     *   * 0     -> no error while parsing
     *   * >0    -> the number of node skipped
     *
     * @return int
     */
    protected function parse()
    {
        $skip = 0;
        $this->level = 0;
        $node = $this->root;
        while (true) {
            $token = $this->lexer->nextToken();
            // reach EOF?
            if ($token->is(Token::EOF)) {
                break;
            }
            // check current parent
            if (null === $node) {
                if ($this->ignoreMalformed) {
                    $node = $this->root;
                } else {
                    throw new \RuntimeException(sprintf('No parent available for %s at %d, document may be malformed.', $token, $this->lexer->getStream()->getPos()));
                }
            }
            switch ($token->getType()) {
                case Token::GROUP_START:
                    $nextNode = Node::create(Node::GROUP, 'GROUP');
                    $node->appendChild($nextNode);
                    $node = $nextNode;
                    $this->level++;
                    break;

                case Token::GROUP_END:
                    $node = $node->getParent();
                    $this->level--;
                    break;

                case Token::KEYWORD:
                case Token::CONTROL:
                case Token::TEXT:
                    $merged = false;
                    if ($this->mergeSpecial) {
                        if ($this->tryMergeText($node, $token, true)) {
                            $merged = true;
                        } else {
                            $this->forceTokenAsText($token);
                        }
                    } else if ($this->ignoreWhitespace && $this->tryMergeText($node, $token, false)) {
                        $merged = true;
                    }
                    if (!$merged) {
                        $nextNode = Node::createFromToken($token);
                        $node->appendChild($nextNode);
                    }
                    break;

                case Token::WHITESPACE:
                    if (!$this->ignoreWhitespace) {
                        $node->appendChild(Node::createFromToken($token));
                    }
                    break;

                default:
                    $skip++;
                    break;
            }
        }
        // incomplete level
        if ($this->level > 0) {
            return false;
        }

        return $skip;
    }

    /**
     * Load and parse tree from a stream.
     *
     * @param \NTLAB\RtfTree\Stream\Stream $stream  Input stream
     * @return boolean
     */
    public function loadFromStream(Stream $stream)
    {
        if ($this->lexer) {
            unset($this->lexer);
        }
        $this->root->clear();
        $this->lexer = new Lexer($stream);
        if (0 === $this->parse()) {

            return true;
        }

        return false;
    }

    /**
     * Load and parse tree from a file.
     *
     * @param string $filename  Input filename
     * @return boolean
     */
    public function loadFromFile($filename)
    {
        if (is_readable($filename)) {
            return $this->loadFromStream(Stream::create(file_get_contents($filename)));
        }

        return false;
    }

    /**
     * Load and parse tree from a string.
     *
     * @param string $content  Input string
     * @return boolean
     */
    public function loadFromString($content)
    {
        if (strlen($content)) {
            return $this->loadFromStream(Stream::create($content));
        }

        return false;
    }

    /**
     * Save rich text to file.
     *
     * @param string $filename  Output filename
     */
    public function saveToFile($filename)
    {
        file_put_contents($filename, $this->getRtf());
    }

    /**
     * Get tree representation of tree nodes.
     *
     * @return string
     */
    public function toStringEx()
    {
        return $this->root->asTree(0, Node::TREE_NODE_INDEX | Node::TREE_NODE_TYPE);
    }

    public function __toString()
    {
        return $this->root->asTree(0);
    }
}