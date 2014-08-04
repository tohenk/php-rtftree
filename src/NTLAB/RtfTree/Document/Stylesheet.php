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

class Stylesheet
{
    const NONE = 0;
    const CHARACTER = 1;
    const PARAGRAPH = 2;
    const SECTION = 3;
    const TABLE = 4;

    /**
     * @var int
     */
    protected $index = 0;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $type = self::PARAGRAPH;

    /**
     * @var boolean
     */
    protected $additive = false;

    /**
     * @var int
     */
    protected $basedOn;

    /**
     * @var int
     */
    protected $next;

    /**
     * @var boolean
     */
    protected $autoUpdate = false;

    /**
     * @var boolean
     */
    protected $hidden = false;

    /**
     * @var int
     */
    protected $link;

    /**
     * @var boolean
     */
    protected $locked = false;

    /**
     * @var boolean
     */
    protected $personal = false;

    /**
     * @var boolean
     */
    protected $compose = false;

    /**
     * @var boolean
     */
    protected $reply = false;

    /**
     * @var int
     */
    protected $styrsid;

    /**
     * @var boolean
     */
    protected $semiHidden = false;

    /**
     * @var \NTLAB\RtfTree\Node\Nodes
     */
    protected $keyCode;

    /**
     * @var \NTLAB\RtfTree\Node\Nodes
     */
    protected $formatting;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->keyCode = new Nodes();
        $this->formatting = new Nodes();
    }

    /**
     * Get the stylesheet index.
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Set the stylesheet index.
     *
     * @param int $index  The index
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * Get the stylesheet name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the stylesheet name.
     *
     * @param string $name  The name
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the stylesheet type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the stylesheet type.
     *
     * @param int $type  The type
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the stylesheet additive.
     *
     * @return boolean
     */
    public function getAdditive()
    {
        return $this->additive;
    }

    /**
     * Set the stylesheet additive.
     *
     * @param boolean $additive  The additive
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setAdditive($additive)
    {
        $this->additive = $additive;

        return $this;
    }

    /**
     * Get the stylesheet based on.
     *
     * @return int
     */
    public function getBasedOn()
    {
        return $this->basedOn;
    }

    /**
     * Set the stylesheet based on.
     *
     * @param int $basedOn  The based on
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setBasedOn($basedOn)
    {
        $this->basedOn = $basedOn;

        return $this;
    }

    /**
     * Get the stylesheet next.
     *
     * @return int
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Set the stylesheet next.
     *
     * @param int $next  The next
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setNext($next)
    {
        $this->next = $next;

        return $this;
    }

    /**
     * Get the stylesheet auto update.
     *
     * @return boolean
     */
    public function getAutoUpdate()
    {
        return $this->autoUpdate;
    }

    /**
     * Set the stylesheet auto update.
     *
     * @param boolean $autoUpdate  The auto update
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setAutoUpdate($autoUpdate)
    {
        $this->autoUpdate = $autoUpdate;

        return $this;
    }

    /**
     * Get the stylesheet hidden.
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set the stylesheet hidden.
     *
     * @param boolean $hidden  The hidden
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get the stylesheet link.
     *
     * @return int
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the stylesheet link.
     *
     * @param int $link  The link
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get the stylesheet locked.
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set the stylesheet locked.
     *
     * @param boolean $locked  The locked
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get the stylesheet personal.
     *
     * @return boolean
     */
    public function getPersonal()
    {
        return $this->personal;
    }

    /**
     * Set the stylesheet personal.
     *
     * @param boolean $personal  The personal
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setPersonal($personal)
    {
        $this->personal = $personal;

        return $this;
    }

    /**
     * Get the stylesheet compose.
     *
     * @return boolean
     */
    public function getCompose()
    {
        return $this->compose;
    }

    /**
     * Set the stylesheet compose.
     *
     * @param boolean $compose  The compose
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setCompose($compose)
    {
        $this->compose = $compose;

        return $this;
    }

    /**
     * Get the stylesheet reply.
     *
     * @return boolean
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * Set the stylesheet reply.
     *
     * @param boolean $reply  The reply
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setReply($reply)
    {
        $this->reply = $reply;

        return $this;
    }

    /**
     * Get the stylesheet styrsid.
     *
     * @return int
     */
    public function getStyrsid()
    {
        return $this->styrsid;
    }

    /**
     * Set the stylesheet styrsid.
     *
     * @param int $styrsid  The styrsid
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setStyrsid($styrsid)
    {
        $this->styrsid = $styrsid;

        return $this;
    }

    /**
     * Get the stylesheet semi hidden.
     *
     * @return boolean
     */
    public function getSemiHidden()
    {
        return $this->semiHidden;
    }

    /**
     * Set the stylesheet semi hidden.
     *
     * @param boolean $semiHidden  The semi hidden
     * @return \NTLAB\RtfTree\Document\Stylesheet
     */
    public function setSemiHidden($semiHidden)
    {
        $this->semiHidden = $semiHidden;

        return $this;
    }

    /**
     * Get stylesheet key code.
     *
     * @return \NTLAB\RtfTree\Node\Nodes
     */
    public function getKeyCode()
    {
        return $this->keyCode;
    }

    /**
     * Get stylesheet formatting.
     *
     * @return \NTLAB\RtfTree\Node\Nodes
     */
    public function getFormatting()
    {
        return $this->formatting;
    }
}