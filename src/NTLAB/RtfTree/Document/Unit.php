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

class Unit
{
    const NATIVE = 0;
    const INCH = 1;
    const CM = 2;
    const MM = 3;
    const PIXEL = 4;

    const TWIPS = 1440;

    /**
     * @var int
     */
    protected $type = self::NATIVE;

    protected $typeNames = array(
        self::NATIVE    => 'Native',
        self::INCH      => 'Inch',
        self::CM        => 'Cm',
        self::MM        => 'Mm',
        self::PIXEL     => 'Pixel',
    );

    /**
     * Constructor.
     *
     * @param int $type  Unit type
     */
    public function __construct($type = null)
    {
        if (null !== $type) {
            $this->type = $type;
        }
    }

    /**
     * Get unit type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set unit type.
     *
     * @param int $type  Unit type
     * @return \NTLAB\RtfTree\Document\Unit
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Convert value to native.
     *
     * @param int $unit  Source unit type
     * @param float $value  Value to convert
     * @return int
     */
    public static function toNative($unit, $value)
    {
        switch ($unit) {
            case static::NATIVE:
                $value = floor($value);
                break;

            case static::INCH:
                $value = floor($value * self::TWIPS);
                break;

            case static::CM:
                $value = floor($value / 2.54 * self::TWIPS);
                break;

            case static::MM:
                $value = floor($value / 25.4 * self::TWIPS);
                break;

            case static::PIXEL:
                $value = floor($value * 20);
                break;
        }

        return $value;
    }

    /**
     * Convert value from native.
     *
     * @param int $unit  The destination unit type
     * @param int $value  The value to convert
     * @return float
     */
    public static function fromNative($unit, $value)
    {
        switch ($unit) {
            case static::NATIVE:
                break;

            case static::INCH:
                $value = $value / self::TWIPS;
                break;

            case static::CM:
                $value = ($value / self::TWIPS) * 2.54;
                break;

            case static::MM:
                $value = ($value / self::TWIPS) * 25.4;
                break;

            case static::PIXEL:
                $value = $value / 20;
                break;
        }

        return $value;
    }
}