<?php

namespace NTLAB\RtfTree\Test;

use NTLAB\RtfTree\Document\Color;
use NTLAB\RtfTree\Document\Document;
use NTLAB\RtfTree\Document\Stylesheet;

class DocumentTest extends BaseTest
{
    /**
     * @var \NTLAB\RtfTree\Document\Document
     */
    protected $document;

    protected function setUp()
    {
        $this->document = new Document();
        $this->document->loadFromFile($this->getFixtureDir().'test-doc-01.rtf');
    }

    public function testDocument()
    {
        $this->assertEquals(1252, $this->document->getCodepage(), 'Code page matched 1252');
        $this->assertEquals(3082, $this->document->getLcid(), 'Language code id matched 3082');
        $this->assertEquals('Msftedit 5.41.15.1515', $this->document->getGenerator(), 'Document generator matched');
    }

    public function testFontTables()
    {
        $this->assertEquals(3, count($this->document->getFontTables()), 'Rtf document has 3 font tables');
        $this->assertEquals('Times New Roman', $this->document->getFontTables()->get(0)->getName(), 'First font is Times New Roman');
        $this->assertEquals('Arial', $this->document->getFontTables()->get(1)->getName(), 'Second font is Arial');
        $this->assertEquals('Arial', $this->document->getFontTables()->get(2)->getName(), 'Third font is Arial');

        $this->assertEquals(0, $this->document->getFontTables()->indexOfKey('Times New Roman'), 'Times New Roman font is at 0');
        $this->assertEquals(1, $this->document->getFontTables()->indexOfKey('Arial'), 'Arial font is at 1');
        $this->assertEquals(null, $this->document->getFontTables()->indexOfKey('nofont'), 'Non existent font is should return NULL');
    }

    public function testColorTables()
    {
        $this->assertEquals(3, count($this->document->getColorTables()), 'Rtf document has 3 color tables');
        $this->assertEquals(Color::BLACK, $this->document->getColorTables()->get(0)->getColor()->getValue(), 'First color is Black');
        $this->assertEquals(Color::NAVY, $this->document->getColorTables()->get(1)->getColor()->getValue(), 'Second color is Navy');
        $this->assertEquals(Color::RED, $this->document->getColorTables()->get(2)->getColor()->getValue(), 'Third color is Red');

        $this->assertEquals(0, $this->document->getColorTables()->indexOfKey(Color::BLACK), 'Color Black is at 0');
        $this->assertEquals(1, $this->document->getColorTables()->indexOfKey(Color::NAVY), 'Color Navy is at 1');
        $this->assertEquals(2, $this->document->getColorTables()->indexOfKey(Color::RED), 'Color Red is at 2');
    }

    public function testStyleSheetTables()
    {
        $this->assertEquals(7, count($this->document->getStyleSheets()), 'Rtf document has 7 style sheets');

        $styleSheet = $this->document->getStyleSheets()->getKey(0);
        $this->assertEquals(0, $styleSheet->getIndex(), 'Stylesheet index matched');
        $this->assertEquals(Stylesheet::PARAGRAPH, $styleSheet->getType(), 'Stylesheet type is stParagraph');
        $this->assertEquals('Normal', $styleSheet->getName(), 'Stylesheet name is Normal');
        $this->assertEquals(0, $styleSheet->getNext(), 'Next stylesheet is 0');
        $this->assertEquals(25, count($styleSheet->getFormatting()), 'Formatting count is 25');

        $styleSheet = $this->document->getStyleSheets()->getKey(1);
        $this->assertEquals(1, $styleSheet->getIndex(), 'Stylesheet index matched');
        $this->assertEquals(Stylesheet::PARAGRAPH, $styleSheet->getType(), 'Stylesheet type is stParagraph');
        $this->assertEquals('heading 1', $styleSheet->getName(), 'Stylesheet name is heading 1');
        $this->assertEquals(0, $styleSheet->getNext(), 'Next is 0');
        $this->assertEquals(0, $styleSheet->getBasedOn(), 'BasedOn is 0');
        $this->assertEquals(2310575, $styleSheet->getStyrsid(), 'Styrsid is 2310575');
        $this->assertEquals(33, count($styleSheet->getFormatting()), 'Formatting count is 33');

        $styleSheet = $this->document->getStyleSheets()->getKey(10);
        $this->assertEquals(10, $styleSheet->getIndex(), 'Stylesheet index matched');
        $this->assertEquals(Stylesheet::CHARACTER, $styleSheet->getType(), 'Stylesheet type is stCharacter');
        $this->assertEquals('Default Paragraph Font', $styleSheet->getName(), 'Stylesheet name is Default Paragraph Font');
        $this->assertEquals(true, $styleSheet->getAdditive(), 'Additive is true');
        $this->assertEquals(true, $styleSheet->getSemiHidden(), 'SemiHidden is true');
        $this->assertEquals(0, count($styleSheet->getFormatting()), 'Formatting count is 0');

        $styleSheet = $this->document->getStyleSheets()->getKey(11);
        $this->assertEquals(11, $styleSheet->getIndex(), 'Stylesheet index matched');
        $this->assertEquals(Stylesheet::TABLE, $styleSheet->getType(), 'Stylesheet type is stTable');
        $this->assertEquals('Normal Table', $styleSheet->getName(), 'Stylesheet name is Normal Table');
        $this->assertEquals(11, $styleSheet->getNext(), 'Next is 11');
        $this->assertEquals(true, $styleSheet->getSemiHidden(), 'SemiHidden is true');
        $this->assertEquals(44, count($styleSheet->getFormatting()), 'Formatting count is 44');
    }

    public function testInfoGroup()
    {
        $docProp = $this->document->getDocumentProperty();
        $this->assertEquals('Test NRtfTree Title', $docProp->getTitle(), 'Title matched');
        $this->assertEquals('Test NRtfTree Subject', $docProp->getSubject(), 'Subject matched');
        $this->assertEquals('Sgoliver (Author)', $docProp->getAuthor(), 'Author matched');
        $this->assertEquals('test;nrtftree;sgoliver', $docProp->getKeywords(), 'Keywords matched');
        $this->assertEquals('This is a test comment.', $docProp->getDocComment(), 'DocComment matched');
        $this->assertEquals('None', $docProp->getOperator(), 'Operator Matched');
        $this->assertEquals(new \DateTime('2008-05-28 18:52'), $docProp->getCreateTime(), 'CreationTime matched');
        $this->assertEquals(new \DateTime('2009-06-29 20:23'), $docProp->getRevisionTime(), 'RevisionTime matched');
        $this->assertEquals(6, $docProp->getVersion(), 'Version matched');
        $this->assertEquals(4, $docProp->getEditingTime(), 'EditingTime matched');
        $this->assertEquals(1, $docProp->getNumOfPages(), 'NumberOfPages matched');
        $this->assertEquals(12, $docProp->getNumOfWords(), 'NumberOfWords matched');
        $this->assertEquals(59, $docProp->getNumOfChars(), 'NumberOfChars matched');
        $this->assertEquals('Sgoliver (Admin)', $docProp->getManager(), 'Manager matched');
        $this->assertEquals('www.sgoliver.net', $docProp->getCompany(), 'Company matched');
        $this->assertEquals('Demos (Category)', $docProp->getCategory(), 'Category matched');
        $this->assertEquals(24579, $docProp->getVersionInternal(), 'InternalVersion matched');

        $this->assertEquals('', $docProp->getComment(), 'Comment matched');
        $this->assertEquals('', $docProp->getHyperlinkBase(), 'HLinkBase matched');
        $this->assertEquals(null, $docProp->getId(), 'Id matched');
        $this->assertEquals(null, $docProp->getPrintTime(), 'PrintTime matched');
        $this->assertEquals(null, $docProp->getBackupTime(), 'BackupTime matched');
    }
}