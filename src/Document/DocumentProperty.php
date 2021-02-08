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

class DocumentProperty
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string
     */
    protected $manager;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $operator;

    /**
     * @var string
     */
    protected $category;

    /**
     * @var string
     */
    protected $keywords;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var string
     */
    protected $docComment;

    /**
     * @var string
     */
    protected $hyperlinkBase;

    /**
     * @var \DateTime
     */
    protected $createTime;

    /**
     * @var \DateTime
     */
    protected $revisionTime;

    /**
     * @var \DateTime
     */
    protected $printTime;

    /**
     * @var \DateTime
     */
    protected $backupTime;

    /**
     * @var int
     */
    protected $version;

    /**
     * @var int
     */
    protected $versionInternal;

    /**
     * @var int
     */
    protected $editingTime;

    /**
     * @var int
     */
    protected $numOfPages;

    /**
     * @var int
     */
    protected $numOfWords;

    /**
     * @var int
     */
    protected $numOfChars;

    /**
     * Get the id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id.
     *
     * @param int $id  The id
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the title.
     *
     * @param string $title  The title
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get the subject.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the subject.
     *
     * @param string $subject  The subject
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Get the author.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the author.
     *
     * @param string $author  The author
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get the manager.
     *
     * @return string
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set the manager.
     *
     * @param string $manager  The manager
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
        return $this;
    }

    /**
     * Get the company.
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the company.
     *
     * @param string $company  The company
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * Get the operator.
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set the operator.
     *
     * @param string $operator  The operator
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
        return $this;
    }

    /**
     * Get the category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the category.
     *
     * @param string $category  The category
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get the keywords.
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set the keywords.
     *
     * @param string $keywords  The keywords
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * Get the comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the comment.
     *
     * @param string $comment  The comment
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Get the doc comment.
     *
     * @return string
     */
    public function getDocComment()
    {
        return $this->docComment;
    }

    /**
     * Set the doc comment.
     *
     * @param string $docComment  The doc comment
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setDocComment($docComment)
    {
        $this->docComment = $docComment;
        return $this;
    }

    /**
     * Get the hyperlink base.
     *
     * @return string
     */
    public function getHyperlinkBase()
    {
        return $this->hyperlinkBase;
    }

    /**
     * Set the hyperlink base.
     *
     * @param string $hyperlinkBase  The hyperlink base
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setHyperlinkBase($hyperlinkBase)
    {
        $this->hyperlinkBase = $hyperlinkBase;
        return $this;
    }

    /**
     * Get the create time.
     *
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set the create time.
     *
     * @param \DateTime $createTime  The create time
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;
        return $this;
    }

    /**
     * Get the revision time.
     *
     * @return \DateTime
     */
    public function getRevisionTime()
    {
        return $this->revisionTime;
    }

    /**
     * Set the revision time.
     *
     * @param \DateTime $revisionTime  The revision time
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setRevisionTime($revisionTime)
    {
        $this->revisionTime = $revisionTime;
        return $this;
    }

    /**
     * Get the print time.
     *
     * @return \DateTime
     */
    public function getPrintTime()
    {
        return $this->printTime;
    }

    /**
     * Set the print time.
     *
     * @param \DateTime $printTime  The print time
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setPrintTime($printTime)
    {
        $this->printTime = $printTime;
        return $this;
    }

    /**
     * Get the backup time.
     *
     * @return \DateTime
     */
    public function getBackupTime()
    {
        return $this->backupTime;
    }

    /**
     * Set the backup time.
     *
     * @param \DateTime $backupTime  The backup time
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setBackupTime($backupTime)
    {
        $this->backupTime = $backupTime;
        return $this;
    }

    /**
     * Get the version.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the version.
     *
     * @param int $version  The version
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Get the version internal.
     *
     * @return int
     */
    public function getVersionInternal()
    {
        return $this->versionInternal;
    }

    /**
     * Set the version internal.
     *
     * @param int $versionInternal  The version internal
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setVersionInternal($versionInternal)
    {
        $this->versionInternal = $versionInternal;
        return $this;
    }

    /**
     * Get the editing time.
     *
     * @return int
     */
    public function getEditingTime()
    {
        return $this->editingTime;
    }

    /**
     * Set the editing time.
     *
     * @param int $editingTime  The editing time
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setEditingTime($editingTime)
    {
        $this->editingTime = $editingTime;
        return $this;
    }

    /**
     * Get the number of pages.
     *
     * @return int
     */
    public function getNumOfPages()
    {
        return $this->numOfPages;
    }

    /**
     * Set the nummber of pages.
     *
     * @param int $numOfPages  The number of pages
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setNumOfPages($numOfPages)
    {
        $this->numOfPages = $numOfPages;
        return $this;
    }

    /**
     * Get the number of words.
     *
     * @return int
     */
    public function getNumOfWords()
    {
        return $this->numOfWords;
    }

    /**
     * Set the number of words.
     *
     * @param int $numOfWords  The number of words
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setNumOfWords($numOfWords)
    {
        $this->numOfWords = $numOfWords;
        return $this;
    }

    /**
     * Get the number of chars.
     *
     * @return int
     */
    public function getNumOfChars()
    {
        return $this->numOfChars;
    }

    /**
     * Set the number of chars.
     *
     * @param int $numOfChars  The number of chars
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function setNumOfChars($numOfChars)
    {
        $this->numOfChars = $numOfChars;
        return $this;
    }

    /**
     * Clear all properties.
     *
     * @return \NTLAB\RtfTree\Document\DocumentProperty
     */
    public function clear()
    {
        foreach (['id', 'title', 'subject', 'author', 'manager',
            'company', 'operator', 'category', 'keywords', 'comment',
            'docComment', 'hyperlinkBase', 'createTime', 'revisionTime',
            'printTime', 'backupTime', 'version', 'versionInternal',
            'editingTime', 'numOfPages', 'numOfWords', 'numOfChars'] as $var) {
            $this->$var = null;
        }
        return $this;
    }
}