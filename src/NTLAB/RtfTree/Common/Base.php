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

namespace NTLAB\RtfTree\Common;

abstract class Base
{
    /**
     * Object type.
     *
     * @var int
     */
    protected $type;

    /**
     * Object key.
     *
     * @var string
     */
    protected $key = null;

    /**
     * Is object has parameter?
     *
     * @var boolean
     */
    protected $hasParameter = false;

    /**
     * Object parameter.
     *
     * @var int
     */
    protected $parameter = null;

    /**
     * Check if object is of type.
     *
     * @param int $type  The desired object type
     * @return boolean
     */
    public function is($type)
    {
        return $this->type === $type;
    }

    /**
     * Get object type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set object type.
     * @param int $value  Object type
     * @return \NTLAB\RtfTree\Common\Base
     */
    public function setType($value)
    {
        $this->type = $value;

        return $this;
    }

    /**
     * Get object key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set object key.
     *
     * @param string $value  Object key
     * @return \NTLAB\RtfTree\Common\Base
     */
    public function setKey($value)
    {
        $this->key = $value;

        return $this;
    }

    /**
     * Check if object has key assigned.
     *
     * @return boolean
     */
    public function hasKey()
    {
        return strlen($this->key) > 0 ? true : false;
    }

    /**
     * Is object has parameter.
     *
     * @return boolean
     */
    public function hasParameter()
    {
        return $this->hasParameter;
    }

    /**
     * Set object if it has parameter.
     *
     * @param boolean $value  Has parameter value
     * @return \NTLAB\RtfTree\Common\Base
     */
    public function setHasParameter($value)
    {
        $this->hasParameter = (bool) $value;

        return $this;
    }

    /**
     * Get object paramater.
     *
     * @return int
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * Set object parameter.
     *
     * @param int $value  Object parameter
     * @return \NTLAB\RtfTree\Common\Base
     */
    public function setParameter($value)
    {
        $this->parameter = $value;

        return $this;
    }

    /**
     * Check if key is match.
     *
     * @param string $keys  The key to match
     * @return boolean
     */
    public function isEquals($keys)
    {
        $keys = is_array($keys) ? $keys : array($keys);
        foreach ($keys as $key) {
            if (strtolower($this->key) === strtolower($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get type as text.
     *
     * @return string
     */
    public function getTypeText()
    {
        return (string) $this->type;
    }

    public function __toString()
    {
        return sprintf('%s: [%s, %s, %s, %d]',
            basename(get_class($this)),
            $this->getTypeText(),
            var_export($this->key, true),
            $this->hasParameter ? 'true' : 'false',
            $this->parameter
        );
    }
}