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

use NTLAB\RtfTree\Common\HexUtil;

/**
 * Standard color from http://www.w3schools.com/cssref/css_colornames.asp.
 *
 * @author Toha
 */
class Color
{
    const ALICEBLUE = 0xf0f8ff;
    const ANTIQUEWHITE = 0xfaebd7;
    const AQUA = 0x00ffff;
    const AQUAMARINE = 0x7fffd4;
    const AZURE = 0xf0ffff;
    const BEIGE = 0xf5f5dc;
    const BISQUE = 0xffe4c4;
    const BLACK = 0x000000;
    const BLANCHEDALMOND = 0xffebcd;
    const BLUE = 0x0000ff;
    const BLUEVIOLET = 0x8a2be2;
    const BROWN = 0xa52a2a;
    const BURLYWOOD = 0xdeb887;
    const CADETBLUE = 0x5f9ea0;
    const CHARTREUSE = 0x7fff00;
    const CHOCOLATE = 0xd2691e;
    const CORAL = 0xff7f50;
    const CORNFLOWERBLUE = 0x6495ed;
    const CORNSILK = 0xfff8dc;
    const CRIMSON = 0xdc143c;
    const CYAN = 0x00ffff;
    const DARKBLUE = 0x00008b;
    const DARKCYAN = 0x008b8b;
    const DARKGOLDENROD = 0xb8860b;
    const DARKGRAY = 0xa9a9a9;
    const DARKGREEN = 0x006400;
    const DARKGREY = 0xa9a9a9;
    const DARKKHAKI = 0xbdb76b;
    const DARKMAGENTA = 0x8b008b;
    const DARKOLIVEGREEN = 0x556b2f;
    const DARKORANGE = 0xff8c00;
    const DARKORCHID = 0x9932cc;
    const DARKRED = 0x8b0000;
    const DARKSALMON = 0xe9967a;
    const DARKSEAGREEN = 0x8fbc8f;
    const DARKSLATEBLUE = 0x483d8b;
    const DARKSLATEGRAY = 0x2f4f4f;
    const DARKSLATEGREY = 0x2f4f4f;
    const DARKTURQUOISE = 0x00ced1;
    const DARKVIOLET = 0x9400d3;
    const DEEPPINK = 0xff1493;
    const DEEPSKYBLUE = 0x00bfff;
    const DIMGRAY = 0x696969;
    const DIMGREY = 0x696969;
    const DODGERBLUE = 0x1e90ff;
    const FIREBRICK = 0xb22222;
    const FLORALWHITE = 0xfffaf0;
    const FORESTGREEN = 0x228b22;
    const FUCHSIA = 0xff00ff;
    const GAINSBORO = 0xdcdcdc;
    const GHOSTWHITE = 0xf8f8ff;
    const GOLD = 0xffd700;
    const GOLDENROD = 0xdaa520;
    const GRAY = 0x808080;
    const GREEN = 0x008000;
    const GREENYELLOW = 0xadff2f;
    const GREY = 0x808080;
    const HONEYDEW = 0xf0fff0;
    const HOTPINK = 0xff69b4;
    const INDIANRED = 0xcd5c5c;
    const INDIGO = 0x4b0082;
    const IVORY = 0xfffff0;
    const KHAKI = 0xf0e68c;
    const LAVENDER = 0xe6e6fa;
    const LAVENDERBLUSH = 0xfff0f5;
    const LAWNGREEN = 0x7cfc00;
    const LEMONCHIFFON = 0xfffacd;
    const LIGHTBLUE = 0xadd8e6;
    const LIGHTCORAL = 0xf08080;
    const LIGHTCYAN = 0xe0ffff;
    const LIGHTGOLDENRODYELLOW = 0xfafad2;
    const LIGHTGRAY = 0xd3d3d3;
    const LIGHTGREEN = 0x90ee90;
    const LIGHTGREY = 0xd3d3d3;
    const LIGHTPINK = 0xffb6c1;
    const LIGHTSALMON = 0xffa07a;
    const LIGHTSEAGREEN = 0x20b2aa;
    const LIGHTSKYBLUE = 0x87cefa;
    const LIGHTSLATEGRAY = 0x778899;
    const LIGHTSLATEGREY = 0x778899;
    const LIGHTSTEELBLUE = 0xb0c4de;
    const LIGHTYELLOW = 0xffffe0;
    const LTGRAY = 0xc0c0c0;
    const MEDGRAY = 0xa0a0a0;
    const DKGRAY = 0x808080;
    const MONEYGREEN = 0xc0dcc0;
    const LEGACYSKYBLUE = 0xf0caa6;
    const CREAM = 0xf0fbff;
    const LIME = 0x00ff00;
    const LIMEGREEN = 0x32cd32;
    const LINEN = 0xfaf0e6;
    const MAGENTA = 0xff00ff;
    const MAROON = 0x800000;
    const MEDIUMAQUAMARINE = 0x66cdaa;
    const MEDIUMBLUE = 0x0000cd;
    const MEDIUMORCHID = 0xba55d3;
    const MEDIUMPURPLE = 0x9370db;
    const MEDIUMSEAGREEN = 0x3cb371;
    const MEDIUMSLATEBLUE = 0x7b68ee;
    const MEDIUMSPRINGGREEN = 0x00fa9a;
    const MEDIUMTURQUOISE = 0x48d1cc;
    const MEDIUMVIOLETRED = 0xc71585;
    const MIDNIGHTBLUE = 0x191970;
    const MINTCREAM = 0xf5fffa;
    const MISTYROSE = 0xffe4e1;
    const MOCCASIN = 0xffe4b5;
    const NAVAJOWHITE = 0xffdead;
    const NAVY = 0x000080;
    const OLDLACE = 0xfdf5e6;
    const OLIVE = 0x808000;
    const OLIVEDRAB = 0x6b8e23;
    const ORANGE = 0xffa500;
    const ORANGERED = 0xff4500;
    const ORCHID = 0xda70d6;
    const PALEGOLDENROD = 0xeee8aa;
    const PALEGREEN = 0x98fb98;
    const PALETURQUOISE = 0xafeeee;
    const PALEVIOLETRED = 0xdb7093;
    const PAPAYAWHIP = 0xffefd5;
    const PEACHPUFF = 0xffdab9;
    const PERU = 0xcd853f;
    const PINK = 0xffc0cb;
    const PLUM = 0xdda0dd;
    const POWDERBLUE = 0xb0e0e6;
    const PURPLE = 0x800080;
    const RED = 0xff0000;
    const ROSYBROWN = 0xbc8f8f;
    const ROYALBLUE = 0x4169e1;
    const SADDLEBROWN = 0x8b4513;
    const SALMON = 0xfa8072;
    const SANDYBROWN = 0xf4a460;
    const SEAGREEN = 0x2e8b57;
    const SEASHELL = 0xfff5ee;
    const SIENNA = 0xa0522d;
    const SILVER = 0xc0c0c0;
    const SKYBLUE = 0x87ceeb;
    const SLATEBLUE = 0x6a5acd;
    const SLATEGRAY = 0x708090;
    const SLATEGREY = 0x708090;
    const SNOW = 0xfffafa;
    const SPRINGGREEN = 0x00ff7f;
    const STEELBLUE = 0x4682b4;
    const TAN = 0xd2b48c;
    const TEAL = 0x008080;
    const THISTLE = 0xd8bfd8;
    const TOMATO = 0xff6347;
    const TURQUOISE = 0x40e0d0;
    const VIOLET = 0xee82ee;
    const WHEAT = 0xf5deb3;
    const WHITE = 0xffffff;
    const WHITESMOKE = 0xf5f5f5;
    const YELLOW = 0xffff00;
    const YELLOWGREEN = 0x9acd32;

    /**
     * @var int
     */
    protected $value = 0;

    /**
     * Set R component of color.
     *
     * @param int $color  The color to set
     * @param int $value  The component value (0-255)
     */
    public static function R(&$color, $value)
    {
        $color = $color | (($value & 0xff) << 16);
    }

    /**
     * Set G component of color.
     *
     * @param int $color  The color to set
     * @param int $value  The component value (0-255)
     */
    public static function G(&$color, $value)
    {
        $color = $color | (($value & 0xff) << 8);
    }

    /**
     * Set G component of color.
     *
     * @param int $color  The color to set
     * @param int $value  The component value (0-255)
     */
    public static function B(&$color, $value)
    {
        $color = $color | ($value & 0xff);
    }

    /**
     * Get color value.
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set color value.
     *
     * @param int $color  The color
     * @return \NTLAB\RtfTree\Document\Color
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get R part of color.
     *
     * @return int
     */
    public function getR()
    {
        return (($this->value >> 16) & 0xff);
    }

    /**
     * Set color R part.
     *
     * @param int $value  The value (0-255)
     * @return \NTLAB\RtfTree\Document\Color
     */
    public function setR($value)
    {
        $this->R($this->value, $value);
        return $this;
    }

    /**
     * Get G part of color.
     *
     * @return int
     */
    public function getG()
    {
        return (($this->value >> 8) & 0xff);
    }

    /**
     * Set color G part.
     *
     * @param int $value  The value (0-255)
     * @return \NTLAB\RtfTree\Document\Color
     */
    public function setG($value)
    {
        $this->G($this->value, $value);
        return $this;
    }

    /**
     * Get B part of color.
     *
     * @return int
     */
    public function getB()
    {
        return ($this->value & 0xff);
    }

    /**
     * Set color B part.
     *
     * @param int $value  The value (0-255)
     * @return \NTLAB\RtfTree\Document\Color
     */
    public function setB($value)
    {
        $this->B($this->value, $value);
        return $this;
    }

    /**
     * Assign colorr.
     *
     * @param \NTLAB\RtfTree\Document\Color $color  Original color
     * @return \NTLAB\RtfTree\Document\Color
     */
    public function assign(Color $color)
    {
        $this->value = $color->value;
        return $this;
    }

    public function __toString()
    {
        return HexUtil::toHex($this->value, 6, '0x');
    }
}