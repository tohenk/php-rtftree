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

namespace NTLAB\RtfTree\Tokenizer;

use NTLAB\RtfTree\Stream\Stream;
use NTLAB\RtfTree\Stream\Reader;

abstract class Tokenizer
{
    /**
     * @var \NTLAB\RtfTree\Stream\Reader
     */
    protected $reader;

    /**
     * @var string
     */
    protected static $default = null;

    /**
     * Create tokenizer.
     *
     * @param \NTLAB\RtfTree\Stream\Stream $stream  Input stream
     * @return \NTLAB\RtfTree\Tokenizer\Tokenizer
     */
    public static function create(Stream $stream)
    {
        if (null === static::$default) {
            static::$default = TokenizerRe::class;
        }

        return new static::$default($stream);
    }

    /**
     * Set default tokenizer.
     *
     * @param string $class  Tokenizer class name
     */
    public static function setDefault($class)
    {
        static::$default = $class;
    }

    /**
     * Constructor.
     *
     * @param \NTLAB\RtfTree\Stream\Stream $stream  Source stream
     */
    public function __construct(Stream $stream)
    {
        $this->reader = new Reader($stream);
    }

    /**
     * Get input stream.
     *
     * @return \NTLAB\RtfTree\Stream\Stream
     */
    public function getStream()
    {
        return $this->reader->getStream();
    }

    /**
     * Get the next token.
     *
     * @return \NTLAB\RtfTree\Tokenizer\Token
     */
    abstract public function nextToken();
}