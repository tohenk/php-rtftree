<?php

namespace NTLAB\RtfTree\Test;

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected $encoding = 'UTF-8';

    protected function getFixtureDir()
    {
        return __DIR__.'/fixtures/';
    }

    protected function getResultDir()
    {
        return __DIR__.'/result/';
    }

    protected function getOutDir()
    {
        return __DIR__.'/out/';
    }

    protected function loadFixture($name)
    {
        return file_get_contents($this->getFixtureDir().$name);
    }

    protected function loadResult($name)
    {
        return file_get_contents($this->getResultDir().$name);
    }

    protected function saveOut($content, $filename)
    {
        file_put_contents($this->getOutDir().$filename, $content);
    }

    protected function unicodestr($text)
    {
        return mb_convert_encoding($text, $this->encoding);
    }
}