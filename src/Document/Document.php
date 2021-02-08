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

use NTLAB\RtfTree\Common\Collection;
use NTLAB\RtfTree\Node\Tree;
use NTLAB\RtfTree\Node\Node;
use NTLAB\RtfTree\Stream\Stream;

class Document
{
    const VIEW_NONE = 0;
    const VIEW_PAGE_LAYOUT = 1;
    const VIEW_OUTLINE = 2;
    const VIEW_MASTER_DOCUMENT = 3;
    const VIEW_NORMAL = 4;
    const VIEW_ONLINE_LAYOUT = 5;

    /**
     * @var \NTLAB\RtfTree\Node\Tree
     */
    protected $tree;

    /**
     * @var \NTLAB\RtfTree\Document\DocumentProperty
     */
    protected $documentProperty;

    /**
     * @var \NTLAB\RtfTree\Document\FontTables
     */
    protected $fontTables;

    /**
     * @var \NTLAB\RtfTree\Document\ColorTables
     */
    protected $colorTables;

    /**
     * @var \NTLAB\RtfTree\Document\Stylesheets
     */
    protected $stylesheets;

    /**
     * @var \NTLAB\RtfTree\Common\Collection
     */
    protected $objects;

    /**
     * @var \NTLAB\RtfTree\Common\Collection
     */
    protected $pictures;

    /**
     * @var \NTLAB\RtfTree\Document\PageSetup
     */
    protected $pageSetup;

    /**
     * @var \NTLAB\RtfTree\Document\Unit
     */
    protected $unit;

    /**
     * @var int
     */
    protected $codepage;

    /**
     * @var int
     */
    protected $lcid;

    /**
     * @var string
     */
    protected $generator;

    /**
     * @var int
     */
    protected $viewkind = self::VIEW_NORMAL;

    /**
     * @var int
     */
    protected $viewscale = 100;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->tree = new Tree();
        $this->documentProperty = new DocumentProperty();
        $this->fontTables = new FontTables();
        $this->colorTables = new ColorTables();
        $this->stylesheets = new Stylesheets();
        $this->objects = new Collection();
        $this->pictures = new Collection();
        $this->pageSetup = new PageSetup($this);
        $this->unit = new Unit(Unit::CM);
    }

    /**
     * Get RTF tree.
     *
     * @return \NTLAB\RtfTree\Node\Tree
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * Get document property.
     *
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function getDocumentProperty()
    {
        return $this->documentProperty;
    }

    /**
     * Get font tables.
     *
     * @return \NTLAB\RtfTree\Document\FontTables
     */
    public function getFontTables()
    {
        return $this->fontTables;
    }

    /**
     * Get color tables.
     *
     * @return \NTLAB\RtfTree\Document\ColorTables
     */
    public function getColorTables()
    {
        return $this->colorTables;
    }

    /**
     * Get Stylesheets.
     *
     * @return \NTLAB\RtfTree\Document\Stylesheets
     */
    public function getStylesheets()
    {
        return $this->stylesheets;
    }

    /**
     * Get document objects.
     *
     * @return \NTLAB\RtfTree\Common\Collection
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * Get document pictures.
     *
     * @return \NTLAB\RtfTree\Common\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Get document page setup.
     *
     * @return \NTLAB\RtfTree\Document\PageSetup
     */
    public function getPageSetup()
    {
        return $this->pageSetup;
    }

    /**
     * Get document measurement unit.
     *
     * @return \NTLAB\RtfTree\Document\Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Get code page.
     *
     * @return int
     */
    public function getCodepage()
    {
        return $this->codepage;
    }

    /**
     * Set code page.
     *
     * @param int $codepage  The code page
     * @return \NTLAB\RtfTree\Document\Document
     */
    public function setCodepage($codepage)
    {
        $this->codepage = $codepage;
        return $this;
    }

    /**
     * Get language code id.
     *
     * @return int
     */
    public function getLcid()
    {
        return $this->lcid;
    }

    /**
     * Set language code id.
     *
     * @param int $lcid  Language code id
     * @return \NTLAB\RtfTree\Document\Document
     */
    public function setLcid($lcid)
    {
        $this->lcid = $lcid;
        return $this;
    }

    /**
     * Get generator.
     *
     * @return string
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * Set generator.
     *
     * @param string $generator  The generator
     * @return \NTLAB\RtfTree\Document\Document
     */
    public function setGenerator($generator)
    {
        $this->generator = $generator;
        return $this;
    }

    /**
     * Get page view kind.
     *
     * @return int
     */
    public function getViewkind()
    {
        return $this->viewkind;
    }

    /**
     * Set page view kind.
     *
     * @param int $viewkind  View kind
     * @return \NTLAB\RtfTree\Document\Document
     */
    public function setViewkind($viewkind)
    {
        $this->viewkind = $viewkind;
        return $this;
    }

    /**
     * Get page view scale.
     *
     * @return int
     */
    public function getViewscale()
    {
        return $this->viewscale;
    }

    /**
     * Set page view scale.
     *
     * @param int $viewscale  View scale
     * @return \NTLAB\RtfTree\Document\Document
     */
    public function setViewscale($viewscale)
    {
        $this->viewscale = $viewscale;
        return $this;
    }

    /**
     * Reset document.
     *
     * @return \NTLAB\RtfTree\Document\Document
     */
    public function reset()
    {
        $this->documentProperty->clear();
        $this->fontTables->clear();
        $this->colorTables->clear();
        $this->stylesheets->clear();
        $this->objects->clear();
        $this->pictures->clear();
        $this->pageSetup->clear();
        $this->codepage = null;
        $this->lcid = null;
        $this->generator = null;
        return $this;
    }

    /**
     * Parse document base.
     *
     * @return \NTLAB\RtfTree\Document\Document
     */
    protected function parseBase()
    {
        if ($node = $this->tree->getRoot()->selectSingleNode('ansicpg')) {
            $this->codepage = $node->getParameter();
        }
        if ($node = $this->tree->getRoot()->selectSingleNode('deflang')) {
            $this->lcid = $node->getParameter();
        }
        if (($node = $this->tree->getRoot()->selectSingleNode('generator')) && ($nextNode = $node->getNextSibling()) && $nextNode->is(Node::TEXT)) {
            $this->generator = substr($nextNode->getKey(), 0, -1);
        }
        if ($node = $this->tree->getRoot()->selectSingleNode('viewkind')) {
            $this->viewkind = $node->getParameter();
        }
        if ($node = $this->tree->getRoot()->selectSingleNode('viewscale')) {
            $this->viewscale = $node->getParameter();
        }
        return $this;
    }

    /**
     * Parse page setup.
     *
     * @return \NTLAB\RtfTree\Document\Document
     */
    protected function parsePageSetup()
    {
        if ($node = $this->tree->getRoot()->selectSingleNode('paperw')) {
            $this->pageSetup->setWidth($node->getParameter());
        }
        if ($node = $this->tree->getRoot()->selectSingleNode('paperh')) {
            $this->pageSetup->setHeight($node->getParameter());
        }
        if ($node = $this->tree->getRoot()->selectSingleNode('margt')) {
            $this->pageSetup->setMarginTop($node->getParameter());
        }
        if ($node = $this->tree->getRoot()->selectSingleNode('margb')) {
            $this->pageSetup->setMarginBottom($node->getParameter());
        }
        if ($node = $this->tree->getRoot()->selectSingleNode('margl')) {
            $this->pageSetup->setMarginLeft($node->getParameter());
        }
        if ($node = $this->tree->getRoot()->selectSingleNode('margr')) {
            $this->pageSetup->setMarginRight($node->getParameter());
        }
        return $this;
    }

    /**
     * Parse document property.
     *
     * @return \NTLAB\RtfTree\Document\Document
     */
    protected function parseProperties()
    {
        if ($this->tree->getRoot()->selectSingleNode('info')) {
            // string property
            foreach (['title', 'subject', 'author', 'manager', 'company', 'operator', 'category', 'keywords', 'comment', 'doccomm' => 'docComment', 'hlinkbase' => 'hyperlinkBase'] as $k => $v) {
                $method = 'set'.ucfirst($v);
                $value = null;
                if ($node = $this->tree->getRoot()->selectSingleNode(is_int($k) ? $v : $k)) {
                    $value = $node->getNextSibling()->getKey();
                }
                $this->documentProperty->$method($value);
            }
            // integer property
            foreach (['id', 'version', 'vern' => 'versionInternal', 'edmins' => 'editingTime', 'nofpages' => 'numOfPages', 'nofwords' => 'numOfWords', 'nofchars' => 'numOfChars'] as $k => $v) {
                $method = 'set'.ucfirst($v);
                $value = null;
                if ($node = $this->tree->getRoot()->selectSingleNode(is_int($k) ? $v : $k)) {
                    $value = $node->getParameter();
                }
                $this->documentProperty->$method($value);
            }
            // date time property
            foreach (['creatim' => 'createTime', 'revtim' => 'revisionTime', 'printim' => 'printTime', 'buptim' => 'backupTime'] as $k => $v) {
                $method = 'set'.ucfirst($v);
                $value = null;
                if ($node = $this->tree->getRoot()->selectSingleNode(is_int($k) ? $v : $k)) {
                    $value = $this->parseDateTime($node->getParent());
                }
                $this->documentProperty->$method($value);
            }
        }
        return $this;
    }

    /**
     * Parse font tables.
     *
     * @return \NTLAB\RtfTree\Document\Document
     */
    protected function parseFontTables()
    {
        if (($firstChild = $this->tree->getRoot()->getFirstChild()) && ($node = $firstChild->selectSingleGroup('fonttbl'))) {
            foreach ($node->getChildren() as $child) {
                if (null === ($fInfo = FontTable::extract($child))) {
                    continue;
                }
                if (null === $fInfo[0]) {
                    $fInfo[0] = count($this->fontTables);
                }
                $this->fontTables[] = FontTable::create($fInfo);
            }
        }
        return $this;
    }

    /**
     * Parse color tables.
     *
     * @return \NTLAB\RtfTree\Document\Document
     */
    protected function parseColorTables()
    {
        if (($firstChild = $this->tree->getRoot()->getFirstChild()) && ($node = $firstChild->selectSingleGroup('colortbl'))) {
            foreach (ColorTable::extract($node) as $color) {
                $this->colorTables[] = new ColorTable($color[0]);
            }
        }
        return $this;
    }

    /**
     * Parse stylesheets.
     *
     * @return \NTLAB\RtfTree\Document\Document
     */
    protected function parseStyleSheets()
    {
        if (($firstChild = $this->tree->getRoot()->getFirstChild()) && ($node = $firstChild->selectSingleGroup('stylesheet'))) {
            foreach ($node->getChildren() as $child) {
                // stylesheet is only on group
                if (!$child->is(Node::GROUP)) {
                    continue;
                }
                $this->stylesheets[] = $this->parseStyleSheet($child);
            }
        }
        return $this;
    }

    /**
     * Parse date time node.
     *
     * @param \NTLAB\RtfTree\Node\Node $node  The date time parent node
     * @return \DateTime
     */
    protected function parseDateTime(Node $node)
    {
        $date = ['yr' => 0, 'mo' => 0, 'dy' => 0, 'hr' => 0, 'min' => 0, 'sec' => 0];
        foreach ($node->getChildren() as $child) {
            if (array_key_exists($child->getKey(), $date)) {
                $date[$child->getKey()] = $child->getParameter();
            }
        }
        if (false !== ($time = mktime($date['hr'], $date['min'], $date['sec'], $date['mo'], $date['dy'], $date['yr']))) {
            $dt = new \DateTime();
            $dt->setTimestamp($time);
            return $dt;
        }
    }

    /**
     * Parse stylesheet.
     *
     * @param \NTLAB\RtfTree\Node\Node $node  Source node
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    protected function parseStyleSheet(Node $node)
    {
        $stylesheet = new Stylesheet();
        foreach ($node->getChildren() as $cnode) {
            // stylesheet type
            foreach (['cs' => Stylesheet::CHARACTER, 's' => Stylesheet::PARAGRAPH, 'ds' => Stylesheet::SECTION, 'ts' => Stylesheet::TABLE] as $k => $v) {
                if ($cnode->isEquals($k)) {
                    $stylesheet->setType($v);
                    $stylesheet->setIndex($cnode->getParameter());
                    continue 2;
                }
            }
            // boolean property
            foreach (['additive', 'sautoupd' => 'autoUpdate', 'shidden' => 'hidden', 'slocked' => 'locked', 'spersonal' => 'personal', 'scompose' => 'compose', 'sreply' => 'reply', 'ssemihidden' => 'semiHidden'] as $k => $v) {
                if ($cnode->isEquals(is_int($k) ? $v : $k)) {
                    $method = 'set'.ucfirst($v);
                    $stylesheet->$method(true);
                    continue 2;
                }
            }
            // integer property
            foreach (['sbasedon' => 'basedOn', 'snext' => 'next', 'slink' => 'link', 'styrsid'] as $k => $v) {
                if ($cnode->isEquals(is_int($k) ? $v : $k)) {
                    $method = 'set'.ucfirst($v);
                    $stylesheet->$method($cnode->getParameter());
                    continue 2;
                }
            }
            // keycode
            if ($cnode->is(Node::GROUP) && count($cnode->getChildren()) > 1 && $cnode->getChildAt(0)->isEquals('*') && $cnode->getChildAt(1)->isEquals('keycode')) {
                for ($i = 2; $i < count($cnode->getChildren()); $i++) {
                    $stylesheet->getKeyCode()->add($cnode->getChildAt($i)->cloneNode());
                }
                continue;
            }
            // name
            if ($cnode->is(Node::TEXT)) {
                $stylesheet->setName(substr($cnode->getKey(), 0, -1));
                continue;
            }
            // formatting
            if (!$cnode->isEquals('*')) {
                $stylesheet->getFormatting()->add($cnode->cloneNode());
                continue;
            }
        }
        return $stylesheet;
    }

    /**
     * Parse objects and pictures.
     *
     * @return \NTLAB\RtfTree\Document\Document
     */
    protected function parseObjects()
    {
        foreach ($this->tree->getRoot()->selectGroup('object') as $node) {
            $this->objects[] = new EmbeddedObject($node);
        }
        foreach ($this->tree->getRoot()->selectGroup('shppict', true) as $node) {
            // ignore picture whithin object
            if ($node->selectParent('object')) {
                continue;
            }
            if ($picNode = $node->selectSingleGroup('pict')) {
                $this->pictures[] = new Picture($picNode);
            }
        }
        return $this;
    }

    /**
     * Load rtf document from stream.
     *
     * @param \NTLAB\RtfTree\Stream\Stream $stream  Input stream
     * @return boolean
     */
    public function loadFromStream(Stream $stream)
    {
        if ($loaded = $this->tree->loadFromStream($stream)) {
            $this
                ->reset()
                ->parseBase()
                ->parsePageSetup()
                ->parseProperties()
                ->parseColorTables()
                ->parseFontTables()
                ->parseStyleSheets()
                ->parseObjects()
            ;
        }
        return $loaded;
    }

    /**
     * Load rtf document from file.
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
     * Load rtf document from string.
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
}