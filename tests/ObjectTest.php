<?php

namespace NTLAB\RtfTree\Test;

use NTLAB\RtfTree\Document\Document;

class ObjectTest extends BaseTest
{
    /**
     * @var \NTLAB\RtfTree\Document\Document
     */
    protected $doc;

    protected function setUp(): void
    {
        $this->doc = new Document();
        $this->doc->loadFromFile($this->getFixtureDir().'test-obj-01.rtf');
        $this->saveOut($this->doc->getTree()->toStringEx(), 'obj-01.txt');
    }

    public function testObjects()
    {
        $this->assertEquals(1, count($this->doc->getObjects()), 'Document contain one object');
        $this->assertEquals('objemb', $this->doc->getObjects()->get(0)->getType(), 'Embedded object type matched');
        $this->assertEquals('Excel.Sheet.8', $this->doc->getObjects()->get(0)->getClass(), 'Embedded object class matched');
        $this->assertEquals($this->loadResult('objhex.txt'), $this->doc->getObjects()->get(0)->getHexData(), 'Object hex data is matched');
        $this->assertEquals($this->loadResult('objbin.dat'), $this->doc->getObjects()->get(0)->getBinaryData(), 'Object binary data is matched');
    }

    public function testPictures()
    {
        $this->assertEquals(1, count($this->doc->getPictures()), 'Document contain one picture');
    }
}