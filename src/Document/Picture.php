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

class Picture extends DocObject
{
    /**
     * @var int
     */
    protected $desiredWidth;

    /**
     * @var int
     */
    protected $desiredHeight;

    /**
     * @var int
     */
    protected $scaleX;

    /**
     * @var int
     */
    protected $scaleY;

    /**
     * @var string
     */
    protected $imageFormat;

    /**
     * @var resource
     */
    protected $image;

    protected function init()
    {
        $this->readProperties();
        $this->readImage();
        $this->loadImage();
    }

    /**
     * Get desired width.
     *
     * @param int Unit type
     * @return float
     */
    public function getDesiredWidth($unit = null)
    {
        return null === $unit ? $this->desiredWidth : Unit::fromNative($unit, $this->desiredWidth);
    }

    /**
     * Set desired width.
     *
     * @param float $desiredWidth  Desired width
     * @return \NTLAB\RtfTree\Document\Picture
     */
    public function setDesiredWidth($desiredWidth)
    {
        $this->desiredWidth = $desiredWidth;

        return $this;
    }

    /**
     * Get desired height.
     *
     * @param int Unit type
     * @return float
     */
    public function getDesiredHeight($unit = null)
    {
        return null === $unit ? $this->desiredHeight : Unit::fromNative($unit, $this->desiredHeight);
    }

    /**
     * Set desired height.
     *
     * @param float $desiredHeight  Desired height
     * @return \NTLAB\RtfTree\Document\Picture
     */
    public function setDesiredHeight($desiredHeight)
    {
        $this->desiredHeight = $desiredHeight;

        return $this;
    }

    /**
     * Get scale X.
     *
     * @return float
     */
    public function getScaleX()
    {
        return $this->scaleX;
    }

    /**
     * Set scale X.
     *
     * @param float $scaleX  Scale X
     * @return \NTLAB\RtfTree\Document\Picture
     */
    public function setScaleX($scaleX)
    {
        $this->scaleX = $scaleX;

        return $this;
    }

    /**
     * Get scale Y.
     *
     * @return float
     */
    public function getScaleY()
    {
        return $this->scaleY;
    }

    /**
     * Set scale Y.
     *
     * @param float $scaleY  Scale Y
     * @return \NTLAB\RtfTree\Document\Picture
     */
    public function setScaleY($scaleY)
    {
        $this->scaleY = $scaleY;

        return $this;
    }

    /**
     * Get image format.
     *
     * @return string
     */
    public function getImageFormat()
    {
        return $this->imageFormat;
    }

    protected function readProperties()
    {
        $this->readProp('picw', $this->width);
        $this->readProp('pich', $this->height);
        $this->readProp('picwgoal', $this->desiredWidth);
        $this->readProp('pichgoal', $this->desiredHeight);
        $this->readProp('picscalex', $this->scaleX);
        $this->readProp('picscaley', $this->scaleY);
    }

    protected function readImage()
    {
        $this->findChild(array('jpegblip', 'pngblip', 'emfblip', 'wmetafile', 'dibitmap', 'wbitmap'), $this->imageFormat);
        if ($this->node) {
            // (Word 97-2000): {\*\shppict {\pict\jpegblip <datos>}}{\nonshppict {\pict\wmetafile8 <datos>}}
            // (Wordpad)     : {\pict\wmetafile8 <datos>}
            $this->setDataNodes($this->node->selectChildNodesTyped(Node::TEXT));
        }
    }

    protected function loadImage()
    {
        if (strlen($this->binaryData)) {
            $this->image = @imagecreatefromstring($this->binaryData);
        }
    }

    /**
     * Create picture node.
     *
     * @param string $filename  Image file name
     * @param int $width  Desired width
     * @param int $height  Desired height
     * @param int $scaleX  Scale X
     * @param int $scaleY  Scale Y
     * @param boolean $whitespace  Add whitespace to picture data
     * @param int $lineSize  Line size of each line when whitespace is set
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return \NTLAB\RtfTree\Node\Node
     */
    public static function create($filename, $width, $height, $scaleX = 100, $scaleY = 100, $whitespace = false, $lineSize = 100)
    {
        switch ($extension = strtolower(substr($filename, strrpos($filename, '.')))) {
            case '.jpg':
                $handle = @imagecreatefromjpeg($filename);
                $type = 'jpegblip';
                break;

            case '.png':
                $handle = @imagecreatefrompng($filename);
                $type = 'pngblip';
                break;

            case '.bmp':
                $handle = @imagecreatefromwbmp($filename);
                $type = 'dibitmap';
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Unsupported image %s.', $extension));
                break;
        }
        if (!$handle) {
            throw new \Exception(sprintf('Image %s is invalid.', $filename));
        }
        $node = Node::createTyped(Node::GROUP);
        $node->appendChild(Node::create(Node::CONTROL, '*'));
        $node->appendChild(Node::create(Node::KEYWORD, 'shppict'));
        $picNode = Node::createTyped(Node::GROUP);
        $picNode->appendChild(Node::create(Node::KEYWORD, 'pict'));
        $picNode->appendChild(Node::create(Node::KEYWORD, $type));
        $picNode->appendChild(Node::create(Node::KEYWORD, 'picw', true, Unit::toNative(Unit::PIXEL, imagesx($handle))));
        $picNode->appendChild(Node::create(Node::KEYWORD, 'pich', true, Unit::toNative(Unit::PIXEL, imagesy($handle))));
        if ($width > 0) {
            $picNode->appendChild(Node::create(Node::KEYWORD, 'picwgoal', true, $width));
        }
        if ($height > 0) {
            $picNode->appendChild(Node::create(Node::KEYWORD, 'pichgoal', true, $height));
        }
        if ($scaleX > 0) {
            $picNode->appendChild(Node::create(Node::KEYWORD, 'picscalex', true, $scaleX));
        }
        if ($scaleY > 0) {
            $picNode->appendChild(Node::create(Node::KEYWORD, 'picscaley', true, $scaleY));
        }
        $data = bin2hex(file_get_contents($filename));
        if ($whitespace) {
            $picNode->appendChild(Node::create(Node::WHITESPACE, "\r\n"));
            while (strlen($data)) {
                $line = substr($data, 0, $lineSize);
                $data = substr($data, $lineSize);
                $picNode->appendChild(Node::create(Node::TEXT, strtolower($line)));
                $picNode->appendChild(Node::create(Node::WHITESPACE, "\r\n"));
            }
        } else {
            $picNode->appendChild(Node::create(Node::TEXT, strtolower($data)));
        }
        $node->appendChild($picNode);

        return $node;
    }
}