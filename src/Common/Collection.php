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

class Collection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var array
     */
    protected $items = array();

    /**
     * Always maintain key to be ordered.
     *
     * @var boolean
     */
    protected $reorder = false;

    /**
     * Allowed item class.
     *
     * @var string
     */
    protected $itemClass = null;

    protected function checkItem($value)
    {
        if ($value && $this->itemClass && !($value instanceof $this->itemClass)) {
            throw new \InvalidArgumentException('%s collection only accept %s.', basename(get_class($this)), basename($this->itemClass));
        }
    }

    /**
     * Maintain collection keys.
     *
     * @return \NTLAB\RtfTree\Common\Collection
     */
    public function maintain()
    {
        if ($this->reorder) {
            $this->items = array_values($this->items);
        }

        return $this;
    }

    /**
     * Empty collection.
     *
     * @return \NTLAB\RtfTree\Common\Collection
     */
    public function clear()
    {
        while (count($this->items)) {
            unset($this->items[0]);
        }
        $this->items = array();

        return $this;
    }

    /**
     * Add an item.
     *
     * @param mixed $value  The item to add
     * @return \NTLAB\RtfTree\Common\Collection
     */
    public function add($value)
    {
        if ($value) {
            $this->checkItem($value);
            $this->items[] = $value;
        }

        return $this;
    }

    /**
     * Append items.
     *
     * @param \NTLAB\RtfTree\Common\Collection $items  Items to append
     * @return \NTLAB\RtfTree\Common\Collection
     */
    public function append($items)
    {
        if ($items && ($items instanceof self || is_array($items))) {
            foreach ($items as $item) {
                $this->add($item);
            }
        }

        return $this;
    }

    /**
     * Insert item at specified index.
     *
     * @param int $index  The insert index position
     * @param mixed $value  The item to insert
     * @return \NTLAB\RtfTree\Common\Collection
     */
    public function insert($index, $value)
    {
        $this->checkItem($value);

        // index is out of bound, appended
        if (empty($this->items) || $index < 0 || $index >= count($this->items)) {
            $this->items[] = $value;
        } else if (0 == $index) {
            $this->items = array_merge(array($value), $this->items);
            $this->maintain();
        } else {
            $first = array_slice($this->items, 0, $index);
            $last = array_slice($this->items, $index);
            $this->items = array_merge($first, array($value), $last);
            $this->maintain();
        }

        return $this;
    }

    /**
     * Remove item from collection.
     *
     * @param mixed $value  The item to remove
     * @return boolean
     */
    public function remove($value)
    {
        if (false !== ($index = $this->indexOf($value))) {
            unset($this->items[$index]);
            $this->maintain();

            return true;
        }

        return false;
    }

    /**
     * Remove items from specified index.
     *
     * @param int $index  Start index
     * @param int $n  The number of items to remove
     * @return int  The number of removed items
     */
    public function removeAt($index, $n = 1)
    {
        $count = 0;
        for ($i = $index + ($n - 1); $i >= $index; $i--) {
            if (isset($this->items[$i])) {
                unset($this->items[$i]);
                $count++;
            }
        }
        $this->maintain();

        return $count;
    }

    /**
     * Get the associated key for given value.
     *
     * @param mixed $value  The value to index
     * @return int
     */
    public function indexOf($value, $startIndex = 0)
    {
        if (null !== $value)
        {
            for ($i = max(array($startIndex, 0)); $i < count($this->items); $i++) {
                if ($this->items[$i] === $value) {
                    return $i;
                }
            }
        }
    }

    /**
     * Get item index by its key.
     *
     * @param mixed $key  The item key
     * @return int
     */
    public function indexOfKey($key)
    {
        for ($i = 0; $i < count($this->items); $i++) {
            if ($this->isKeyEqual($this->items[$i], $key)) {
                return $i;
            }
        }
    }

    /**
     * Get collection item.
     *
     * @param int $index  The item index
     * @return mixed
     */
    public function get($index)
    {
        if ($index >= 0 && $index < count($this->items)) {
            return $this->items[$index];
        }
    }

    /**
     * Get collection item by its key.
     *
     * @param mixed $key  The item key
     * @return mixed
     */
    public function getKey($key)
    {
        foreach ($this->items as $item) {
            if ($this->isKeyEqual($item, $key)) {
                return $item;
            }
        }
    }

    /**
     * Check if item key is match.
     *
     * @param mixed $value  The item
     * @param mixed $key  The key to match
     * @return boolean
     */
    protected function isKeyEqual($value, $key)
    {
        return false;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->checkItem($value);

        if (null === $offset) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
            $this->maintain();
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
        $this->maintain();
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    public function count()
    {
        return count($this->items);
    }
}