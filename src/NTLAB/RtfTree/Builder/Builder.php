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

namespace NTLAB\RtfTree\Builder;

use NTLAB\RtfTree\Node\Node;
use NTLAB\RtfTree\Node\Nodes;
use NTLAB\RtfTree\Node\Tree;
use NTLAB\RtfTree\Document\Color;
use NTLAB\RtfTree\Document\ColorTable;
use NTLAB\RtfTree\Document\Document;
use NTLAB\RtfTree\Document\Font;
use NTLAB\RtfTree\Document\FontTable;
use NTLAB\RtfTree\Document\Paragraph;
use NTLAB\RtfTree\Document\PageSetup;
use NTLAB\RtfTree\Document\Picture;
use NTLAB\RtfTree\Document\Unit;

class Builder
{
    /**
     * @var \NTLAB\RtfTree\Document\Document
     */
    protected $document;

    /**
     * @var \NTLAB\RtfTree\Node\Node
     */
    protected $data;

    /**
     * @var \NTLAB\RtfTree\Node\Node
     */
    protected $parent;

    /**
     * @var \NTLAB\RtfTree\Document\Font
     */
    protected $font;

    /**
     * @var \NTLAB\RtfTree\Document\Font
     */
    protected $defaultFont;

    /**
     * @var \NTLAB\RtfTree\Document\Paragraph
     */
    protected $paragraph;

    /**
     * @var boolean
     */
    protected $addClosingParapgraph = false;

    /**
     * @var boolean
     */
    protected $detectFontFamilies = false;

    /**
     * @var boolean
     */
    protected $dirty;

    /**
     * Constructor.
     *
     * @param \NTLAB\RtfTree\Document\Document $document  The document
     */
    public function __construct($document)
    {
        $this->document = $document;
        $this->data = new Node();
        $this->defaultFont = new Font();
        $this->defaultFont
            ->setName('Arial')
            ->setSize(11)
            ->setBold(false)
            ->setItalic(false)
            ->setUnderline(false)
            ->setStrikethrough(false)
            ->setColor(Color::BLACK);
        $this->paragraph = new Paragraph();
        $this->initializeDoc();
    }

    protected function initializeDoc()
    {
        // always add black color
        if (0 === count($this->document->getColorTables())) {
            $this->document->getColorTables()->add(new ColorTable(Color::BLACK));
        }
    }

    /**
     * Get add closing parapgraph value.
     *
     * @return boolean
     */
    public function getAddClosingParagraph()
    {
        return $this->addClosingParapgraph;
    }

    /**
     * Set add closing paragraph value.
     *
     * @param boolean $value  The value
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setAddClosingParagraph($value)
    {
        $this->addClosingParapgraph = $value;

        return $this;
    }

    /**
     * Get detect font families value.
     *
     * @return boolean
     */
    public function getDetectFontFamilies()
    {
        return $this->detectFontFamilies;
    }

    /**
     * Set detect font families value.
     *
     * @param boolean $value  The value
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setDetectFontFamilies($value)
    {
        $this->detectFontFamilies = $value;

        return $this;
    }

    /**
     * Get document.
     *
     * @return \NTLAB\RtfTree\Document\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Get paragraph.
     *
     * @return \NTLAB\RtfTree\Document\Paragraph
     */
    public function getParagraph()
    {
        return $this->paragraph;
    }

    /**
     * Get default font.
     *
     * @return \NTLAB\RtfTree\Document\Font
     */
    public function getDefaulfFont()
    {
        return $this->defaultFont;
    }

    /**
     * Get node tree.
     *
     * @return \NTLAB\RtfTree\Node\Tree
     */
    protected function getTree()
    {
        return $this->document->getTree();
    }

    /**
     * Get tree main group (the first child).
     *
     * @return \NTLAB\RtfTree\Node\Node
     */
    protected function getMainGroup()
    {
        return $this->getTree()->getMainGroup();
    }

    /**
     * Force the main group of tree to be created.
     *
     * @return boolean
     */
    protected function forceMainGroup()
    {
        if ($this->getTree()->getRoot()->hasChildNodes()) {
            return false;
        }
        $this->getTree()->addMainGroup();

        return true;
    }

    /**
     * Create font if its not already created.
     *
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function createFont()
    {
        if (null === $this->font) {
            $this->font = new Font();
        }

        return $this;
    }

    /**
     * Add node.
     *
     * @param \NTLAB\RtfTree\Node\Node $node  Node to add
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function addNode(Node $node)
    {
        if (true !== $this->dirty) {
            $this->dirty = true;
        }
        if (null === $this->parent) {
            $this->parent = $this->data;
        }
        $this->parent->appendChild($node);

        return $this;
    }

    /**
     * Add nodes.
     *
     * @param \NTLAB\RtfTree\Node\Nodes $nodes  Nodes to add
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function addNodes(Nodes $nodes)
    {
        if ($nodes) {
            foreach ($nodes as $node) {
                $this->addNode($node);
            }
        }

        return $this;
    }

    /**
     * Get the first pard node index of the main group.
     *
     * @throws \Exception
     * @return int
     */
    protected function getFirstPard()
    {
        // insert before first paragraph
        if (!($pard = $this->getMainGroup()->selectSingleNode('pard'))) {
            throw new \Exception('Unable to find first paragraph node.');
        }

        return $pard->getNodeIndex();
    }

    /**
     * Insert document entity before the first paragraph.
     *
     * @param \NTLAB\RtfTree\Node\Node $node  The node entity
     * @throws \Exception
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function insertEntity(Node $node)
    {
        $pard = $this->getFirstPard();
        $this->getMainGroup()->insertChild($pard, $node);

        return $this;
    }

    protected function buildBase()
    {
        // empty tree
        if ($this->forceMainGroup()) {
            $this->getMainGroup()->appendChild(Node::create(Node::KEYWORD, 'rtf', true, 1));
            $this->getMainGroup()->appendChild(Node::create(Node::KEYWORD, 'ansi'));
            $this->getMainGroup()->appendChild(Node::create(Node::KEYWORD, 'ansicpg', true, $this->document->getCodepage()));
            $this->getMainGroup()->appendChild(Node::create(Node::KEYWORD, 'deff', true, 0));
            $this->getMainGroup()->appendChild(Node::create(Node::KEYWORD, 'deflang', true, $this->document->getLcid()));
            $this->getMainGroup()->appendChild(Node::create(Node::KEYWORD, 'pard'));
        } else {
            if ($node = $this->getMainGroup()->selectSingleNode('ansicpg')) {
                $node->setParameter($this->getDocument()->getCodepage());
            }
            if ($node = $this->getMainGroup()->selectSingleNode('deflang')) {
                $node->setParameter($this->getDocument()->getLcid());
            }
        }

        return $this;
    }

    protected function buildFontTables()
    {
        // add font tables group if not exist
        if (!($node = $this->getMainGroup()->selectSingleGroup('fonttbl'))) {
            $node = Node::createTyped(Node::GROUP);
            $node->appendChild(Node::create(Node::KEYWORD, 'fonttbl'));
            $this->insertEntity($node);
        }
        // check for existing fonts
        $fonts = array();
        foreach ($node->selectNodesTyped(Node::GROUP) as $cnode) {
            if (null === ($fInfo = FontTable::extract($cnode))) {
                continue;
            }
            $fonts[$fInfo[1]] = $cnode;
        }
        // add fonts
        foreach ($this->document->getFontTables() as $fontTable) {
            if (isset($fonts[$fontTable->getName()])) {
                unset($fonts[$fontTable->getName()]);
                continue;
            }
            if ($this->detectFontFamilies) {
                $fontTable->detectFamilies();
            }
            $node->appendChild($fontTable->createNode());
        }
        // remove unused fonts
        foreach ($fonts as $fName => $fNode) {
            $node->removeChild($fNode);
        }

        return $this;
    }

    protected function buildColorTables()
    {
        // add color tables group if not exist
        if (!($node = $this->getMainGroup()->selectSingleGroup('colortbl'))) {
            $node = Node::createTyped(Node::GROUP);
            $node->appendChild(Node::create(Node::KEYWORD, 'colortbl'));
            $this->insertEntity($node);
        }
        // check for existing colors
        $colors = array();
        $nodes = array();
        foreach (ColorTable::extract($node) as $data) {
            $colors[] = $data[0];
            $nodes[] = $data[1];
        }
        // add colors
        foreach ($this->document->getColorTables() as $colorTable) {
            if (in_array($colorTable->getColor()->getValue(), $colors)) {
                $key = array_search($colorTable->getColor()->getValue(), $colors);
                unset($colors[$key]);
                unset($nodes[$key]);
                continue;
            }
            $node->appendChilds($colorTable->createNodes());
        }
        // remove unused colors
        foreach ($nodes as $data) {
            foreach ($data as $cnode) {
                $node->removeChild($cnode);
            }
        }

        return $this;
    }

    protected function buildGenerator()
    {
        if (null === ($generator = $this->document->getGenerator())) {
            $generator = sprintf('%s %s', Tree::NAME, Tree::VERSION);
        }
        // add generator group if not exist
        if (!($node = $this->getMainGroup()->selectSingleGroup('generator', true))) {
            $node = Node::createTyped(Node::GROUP);
            $node->appendChild(Node::create(Node::CONTROL, '*'));
            $node->appendChild(Node::create(Node::KEYWORD, 'generator'));
            $node->appendChild(Node::create(Node::TEXT, $generator.';'));
            $this->insertEntity($node);
        } else {
            if ($textNode = $node->selectSingleNodeTyped(Node::TEXT)) {
                $textNode->setKey($generator.';');
            }
        }

        return $this;
    }

    protected function buildDocSettings()
    {
        foreach (array(
            'viewkind'  => $this->document->getViewkind(),
            'viewscale' => $this->document->getViewscale(),
            'paperw'    => $this->document->getPageSetup()->getWidth(Unit::NATIVE),
            'paperh'    => $this->document->getPageSetup()->getHeight(Unit::NATIVE),
            'margl'     => $this->document->getPageSetup()->getMarginLeft(Unit::NATIVE),
            'margr'     => $this->document->getPageSetup()->getMarginRight(Unit::NATIVE),
            'margt'     => $this->document->getPageSetup()->getMarginTop(Unit::NATIVE),
            'margb'     => $this->document->getPageSetup()->getMarginBottom(Unit::NATIVE),
        ) as $key => $value) {
            if (null === $value) {
                continue;
            }
            if (!($node = $this->getMainGroup()->selectSingleNode($key))) {
                $node = Node::create(Node::KEYWORD, $key, true, $value);
                $this->insertEntity($node);
            } else {
                $node->setParameter($value);
            }
        }

        return $this;
    }

    protected function buildData()
    {
        $this->emptyPard();
        foreach ($this->data->getChildren() as $node) {
            $this->getMainGroup()->appendChild($node->cloneNode());
        }
        if ($this->addClosingParapgraph || !$this->data->getLastChild()->isEquals('par')) {
            $this->getMainGroup()->appendChild(Node::create(Node::KEYWORD, 'par'));
        }

        return $this;
    }

    /**
     * Build text node.
     *
     * @param string $text  The text
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function buildText($text)
    {
        if (null === $this->font) {
            $this->useDefaultFont();
        }
        $this->addNodes(Node::createText($text, true));

        return $this;
    }

    /**
     * Build font name node.
     *
     * @param \NTLAB\RtfTree\Document\Font $font  Reference font
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function buildFontName(Font $font)
    {
        $fontTables = $this->document->getFontTables();
        if (null === $fontTables->indexOfKey($font->getName())) {
            $fontTables->add(new FontTable(count($fontTables), $font->getName()));
        }
        $fontTable = $fontTables->getKey($font->getName());
        $this->addNode(Node::create(Node::KEYWORD, 'f', true, $fontTable->getIndex()));

        return $this;
    }

    /**
     * Build font color node.
     *
     * @param \NTLAB\RtfTree\Document\Font $font  Reference font
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function buildFontColor(Font $font)
    {
        $colorTables = $this->document->getColorTables();
        if (null === $colorTables->indexOfKey($font->getColor()->getValue())) {
            $colorTables->add(new ColorTable($font->getColor()->getValue()));
        }
        $this->addNode(Node::create(Node::KEYWORD, 'cf', true, $colorTables->indexOfKey($font->getColor()->getValue())));

        return $this;
    }

    /**
     * Build font size node.
     *
     * @param \NTLAB\RtfTree\Document\Font $font  Reference font
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function buildFontSize(Font $font)
    {
        $this->addNode(Node::create(Node::KEYWORD, 'fs', true, round($font->getSize() * 2)));

        return $this;
    }

    /**
     * Build font bold node.
     *
     * @param \NTLAB\RtfTree\Document\Font $font  Reference font
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function buildFontBold(Font $font)
    {
        if ($font->getBold()) {
            $this->addNode(Node::create(Node::KEYWORD, 'b'));
        } else {
            $this->addNode(Node::create(Node::KEYWORD, 'b', true, 0));
        } 

        return $this;
    }

    /**
     * Build font italic node.
     *
     * @param \NTLAB\RtfTree\Document\Font $font  Reference font
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function buildFontItalic(Font $font)
    {
        if ($font->getItalic()) {
            $this->addNode(Node::create(Node::KEYWORD, 'i'));
        } else {
            $this->addNode(Node::create(Node::KEYWORD, 'i', true, 0));
        } 

        return $this;
    }

    /**
     * Build font underline node.
     *
     * @param \NTLAB\RtfTree\Document\Font $font  Reference font
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function buildFontUnderline(Font $font)
    {
        if ($font->getUnderline()) {
            $this->addNode(Node::create(Node::KEYWORD, 'ul'));
        } else {
            $this->addNode(Node::create(Node::KEYWORD, 'ulnone'));
        } 

        return $this;
    }

    /**
     * Build font strikethrough node.
     *
     * @param \NTLAB\RtfTree\Document\Font $font  Reference font
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function buildFontStrikethrough(Font $font)
    {
        if ($font->getStrikethrough()) {
            $node = Node::createTyped(Node::GROUP);
            $node->appendChild(Node::create(Node::KEYWORD, 'strike'));
            $this->addNode($node);
            $this->parent = $node;
        } else {
            if ($this->parent !== $this->data) {
                $this->parent = $this->data;
            }
        }

        return $this;
    }

    /**
     * Build paragraph alignment node.
     *
     * @param \NTLAB\RtfTree\Document\Paragraph $paragraph  Reference paragraph
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function buildParagraphAlignment(Paragraph $paragraph)
    {
        $this->addNode(Node::create(Node::KEYWORD, Paragraph::getKeyword($paragraph->getAlignment())));

        return $this;
    }

    /**
     * Build paragraph indent node.
     *
     * @param \NTLAB\RtfTree\Document\Paragraph $paragraph  Reference paragraph
     * @param int  Indent flags
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    protected function buildParagraphIndent(Paragraph $paragraph, $flags = 0)
    {
        // first indent
        if (($flags & 0x01) === 0x01 && null !== ($value = $paragraph->getIndent())) {
            $this->addNode(Node::create(Node::KEYWORD, 'fi', true, $value - $paragraph->getLeftIndent()));
        }
        if (($flags & 0x02) === 0x02 && null !== ($value = $paragraph->getLeftIndent())) {
            $this->addNode(Node::create(Node::KEYWORD, 'li', true, $value));
        }
        if (($flags & 0x04) === 0x04 && null !== ($value = $paragraph->getRightIndent())) {
            $this->addNode(Node::create(Node::KEYWORD, 'ri', true, $value));
        }

        return $this;
    }

    /**
     * Use default font.
     *
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function useDefaultFont()
    {
        $this->updateFont($this->defaultFont);

        return $this;
    }

    /**
     * Add text node.
     *
     * @param string $text  The text
     * @param \NTLAB\RtfTree\Document\Font $font  Reference font
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function addText($text, $font = null)
    {
        if (null !== $font) {
            $this->updateFont($font);
        }
        $this->buildText($text);

        return $this;
    }

    /**
     * Add new line node.
     *
     * @param int $count  The number of new line
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function addNewLine($count = 1)
    {
        while ($count) {
            $this->addNode(Node::create(Node::KEYWORD, 'line'));
            $count--;
        }

        return $this;
    }

    /**
     * Add new paragraph node.
     *
     * @param int $count  The number of new paragraph
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function addNewParagraph($count = 1)
    {
        while ($count) {
            $this->addNode(Node::create(Node::KEYWORD, 'par'));
            $count--;
        }

        return $this;
    }

    /**
     * Add new paragraph and update paragraph from reference.
     *
     * @param \NTLAB\RtfTree\Document\Paragraph $paragraph  Reference paragraph
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function addParagraph(Paragraph $paragraph)
    {
        $this->addNewParagraph();
        $this->updateParagraph($paragraph);

        return $this;
    }

    /**
     * Add an image node.
     *
     * @param string $filename  Image filename
     * @param int $width  Desired width
     * @param int $height  Desired height
     * @param int $scaleX  Scale X
     * @param int $scaleY  Scale Y
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function addImage($filename, $width = 0, $height = 0, $scaleX = 100, $scaleY = 100)
    {
        if (is_readable($filename)) {
            $this->addNode(Picture::create($filename, $width, $height, $scaleX, $scaleY, $this->getTree()->getIgnoreWhitespace() ? false : true));
        }

        return $this;
    }

    /**
     * Add whitespace node.
     *
     * @param string $str  Whitespace text
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function addWhitespace($str = "\r\n")
    {
        $this->addNode(Node::create(Node::WHITESPACE, $str));

        return $this;
    }

    /**
     * Add character reset node.
     *
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function addCharReset()
    {
        $this->addNode(Node::create(Node::KEYWORD, 'plain'));

        return $this;
    }

    /**
     * Add paragraph reset node.
     *
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function addParagraphReset()
    {
        $this->addNode(Node::create(Node::KEYWORD, 'pard'));

        return $this;
    }

    /**
     * Add format reset node.
     *
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function addFormatReset()
    {
        $this
            ->addCharReset()
            ->addParagraphReset();

        return $this;
    }

    /**
     * Update font.
     *
     * @param \NTLAB\RtfTree\Document\Font $font  Source font
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function updateFont($font)
    {
        if (null !== $font) {
            if (null !== $this->document->getFontTables()->indexOfKey($font->getName())) {
                if (null === $this->font || $this->font->getColor()->getValue() !== $font->getColor()->getValue()) {
                    $this->buildFontColor($font);
                }
                if (null === $this->font || $this->font->getSize() !== $font->getSize()) {
                    $this->buildFontSize($font);
                }
                if (null === $this->font || $this->font->getName() !== $font->getName()) {
                    $this->buildFontName($font);
                }
                if (null === $this->font || $this->font->getBold() !== $font->getBold()) {
                    $this->buildFontBold($font);
                }
                if (null === $this->font || $this->font->getItalic() !== $font->getItalic()) {
                    $this->buildFontItalic($font);
                }
                if (null === $this->font || $this->font->getUnderline() !== $font->getUnderline()) {
                    $this->buildFontUnderline($font);
                }
                if (null === $this->font || $this->font->getStrikethrough() !== $font->getStrikethrough()) {
                    $this->buildFontStrikethrough($font);
                }
                $this->createFont();
                $this->font->assign($font);
            } else {
                $this->setFontColor($font->getColor()->getValue());
                $this->setFontSize($font->getSize());
                $this->setFontName($font->getName());
                $this->setFontBold($font->getBold());
                $this->setFontItalic($font->getItalic());
                $this->setFontUnderline($font->getUnderline());
                $this->setFontStrikethrough($font->getStrikethrough());
            }
        }

        return $this;
    }

    /**
     * Update paragraph.
     *
     * @param \NTLAB\RtfTree\Document\Paragraph $paragraph  Source paragraph
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function updateParagraph($paragraph)
    {
        if ($paragraph) {
            $this->setParagraphAlignment($paragraph->getAlignment());
            $this->setParagraphIndent($paragraph->getIndent(), $paragraph->getLeftIndent(), $paragraph->getRightIndent());
        }

        return $this;
    }

    /**
     * Set paragraph alignment.
     *
     * @param int $alignment  Paragraph alignment
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setParagraphAlignment($alignment)
    {
        if ($this->paragraph->getAlignment() !== $alignment) {
            $this->paragraph->setAlignment($alignment);
            $this->buildParagraphAlignment($this->paragraph);
        }

        return $this;
    }

    /**
     * Set paragraph indentation.
     *
     * @param int $indent  Paragraph indent
     * @param int $left  Paragraph left indent
     * @param int $right  Paragraph right indent
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setParagraphIndent($indent, $left, $right)
    {
        $updates = 0;
        if (null !== $indent && $this->paragraph->getIndent() !== $indent) {
            $this->paragraph->setIndent($indent);
            $updates = $updates | 0x01;
        }
        if (null !== $left && $this->paragraph->getLeftIndent() !== $left) {
            $this->paragraph->setLeftIndent($left);
            $updates = $updates | 0x02;
        }
        if (null !== $right && $this->paragraph->getRightIndent() !== $right) {
            $this->paragraph->setRightIndent($right);
            $updates = $updates | 0x04;
        }
        if ($updates > 0) {
            $this->buildParagraphIndent($this->paragraph, $updates);
        }

        return $this;
    }

    /**
     * Set font bold.
     *
     * @param boolean $value  The bold value
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setFontBold($value)
    {
        $this->createFont();
        if ($this->font->getBold() !== $value) {
            $this->font->setBold((bool) $value);
            $this->buildFontBold($this->font);
        }

        return $this;
    }

    /**
     * Set font underline.
     *
     * @param boolean $value  The underline value
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setFontUnderline($value)
    {
        $this->createFont();
        if ($this->font->getUnderline() !== $value) {
            $this->font->setUnderline((bool) $value);
            $this->buildFontUnderline($this->font);
        }

        return $this;
    }

    /**
     * Set font italic.
     *
     * @param boolean $value  The italic value
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setFontItalic($value)
    {
        $this->createFont();
        if ($this->font->getItalic() !== $value) {
            $this->font->setItalic((bool) $value);
            $this->buildFontItalic($this->font);
        }

        return $this;
    }

    /**
     * Set font strikethrough.
     *
     * @param boolean $value  The strikethrough value
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setFontStrikethrough($value)
    {
        $this->createFont();
        if ($this->font->getStrikethrough() !== $value) {
            $this->font->setStrikethrough((bool) $value);
            $this->buildFontStrikethrough($this->font);
        }

        return $this;
    }

    /**
     * Set font color.
     *
     * @param int $value  The color RGB
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setFontColor($value)
    {
        $this->createFont();
        if ($this->font->getColor()->getValue() !== $value) {
            $this->font->getColor()->setValue($value);
            $this->buildFontColor($this->font);
        }

        return $this;
    }

    /**
     * Set font size.
     *
     * @param float $size  Font size
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setFontSize($size)
    {
        $this->createFont();
        if ($this->font->getSize() !== $size) {
            $this->font->setSize($size);
            $this->buildFontSize($this->font);
        }

        return $this;
    }

    /**
     * Set font name.
     *
     * @param string $name  Font name
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function setFontName($name)
    {
        $this->createFont();
        if ($this->font->getName() !== $name) {
            $this->font->setName($name);
            $this->buildFontName($this->font);
        }

        return $this;
    }

    /**
     * Update tree.
     *
     * @param boolean $force  Force update even if the document is not modified
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function updateTree($force = false)
    {
        if ($this->dirty || $force) {
            $this->buildBase();
            $this->buildFontTables();
            $this->buildColorTables();
            $this->buildGenerator();
            $this->buildDocSettings();
            $this->buildData();
        }

        return $this;
    }

    /**
     * Empty all paragraph from tree.
     *
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function emptyPard()
    {
        $pard = $this->getFirstPard();
        while (true) {
            if (!($node = $this->getMainGroup()->getChildAt($pard + 1))) {
                break;
            }
            $this->getMainGroup()->removeChild($node);
        }

        return $this;
    }

    /**
     * Clear builder nodes.
     *
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function clear()
    {
        $this->dirty = false;
        $this->parent = null;
        $this->data->clear();
        $this->paragraph->clear();
        if ($this->font) {
            unset($this->font);
            $this->font = null;
        }
        $this->document->reset();
        $this->initializeDoc();

        return $this;
    }

    /**
     * Get RTF document.
     *
     * @return string
     */
    public function getRtf()
    {
        $this->updateTree();

        return $this->getTree()->getRtf();
    }

    /**
     * Get text document.
     *
     * @return string
     */
    public function getText()
    {
        $this->updateTree();

        return $this->getTree()->getText();
    }

    /**
     * Save the document.
     *
     * @param string $filename  Output filename
     * @return \NTLAB\RtfTree\Builder\Builder
     */
    public function save($filename)
    {
        $this->updateTree();
        file_put_contents($filename, $this->getRtf());

        return $this;
    }
}
