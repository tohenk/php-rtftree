<?php

namespace NTLAB\RtfTree\Test;

use NTLAB\RtfTree\Builder\Builder;
use NTLAB\RtfTree\Document\Color;
use NTLAB\RtfTree\Document\Document;
use NTLAB\RtfTree\Document\Font;
use NTLAB\RtfTree\Document\Paragraph;
use NTLAB\RtfTree\Document\Unit;

class BuilderTest extends BaseTest
{
    public function testCreateSimple()
    {
        $builder = new Builder(new Document());

        $builder->getDocument()
            ->setCodepage(1252)
            ->setLcid(3082)
        ;
        $builder->setAddClosingParagraph(true);
        $builder->setDetectFontFamilies(true);

        $font = new Font();
        $font
            ->setName('Arial')
            ->setSize(10)
            ->setBold(true)
            ->setUnderline(true)
            ->setColor(Color::DARKBLUE)
        ;
        $builder->updateFont($font);

        $paragraph = new Paragraph();
        $paragraph->setAlignment(Paragraph::ALIGN_JUSTIFY);
        $builder->updateParagraph($paragraph);

        $builder->addText('First Paragraph');
        $builder->addNewParagraph(2);

        $builder->setFontBold(false);
        $builder->setFontUnderline(false);
        $builder->setFontColor(Color::RED);

        $builder->addText('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer quis eros at tortor pharetra laoreet. Donec tortor diam, imperdiet ut porta quis, congue eu justo.');
        $builder->addText('Quisque viverra tellus id mauris tincidunt luctus. Fusce in interdum ipsum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.');
        $builder->addText('Donec ac leo justo, vitae rutrum elit. Nulla tellus elit, imperdiet luctus porta vel, consectetur quis turpis. Nam purus odio, dictum vitae sollicitudin nec, tempor eget mi.');
        $builder->addText('Etiam vitae porttitor enim. Aenean molestie facilisis magna, quis tincidunt leo placerat in. Maecenas malesuada eleifend nunc vitae cursus.');
        $builder->addNewParagraph(2);

        $rtf1 = $builder->getRtf();
        $builder->save($this->getOutDir().'doc1.rtf');

        $builder->addText('Second Paragraph', $font);
        $builder->addNewParagraph(2);
    
        $font
            ->setName('Courier New')
            ->setColor(Color::GREEN)
            ->setBold(false)
            ->setUnderline(false)
        ;
        $builder->updateFont($font);

        $builder->setParagraphAlignment(Paragraph::ALIGN_LEFT);
        $builder->setParagraphIndent(Unit::toNative(Unit::CM, 3), Unit::toNative(Unit::CM, 2), Unit::toNative(Unit::CM, 2));

        $builder->addText('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer quis eros at tortor pharetra laoreet. Donec tortor diam, imperdiet ut porta quis, congue eu justo.');
        $builder->addText('Quisque viverra tellus id mauris tincidunt luctus. Fusce in interdum ipsum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.');
        $builder->addText('Donec ac leo justo, vitae rutrum elit. Nulla tellus elit, imperdiet luctus porta vel, consectetur quis turpis. Nam purus odio, dictum vitae sollicitudin nec, tempor eget mi.');
        $builder->addText('Etiam vitae porttitor enim. Aenean molestie facilisis magna, quis tincidunt leo placerat in. Maecenas malesuada eleifend nunc vitae cursus.');
        $builder->addNewParagraph(2);

        $builder->updateFont($font);
        $builder->setFontUnderline(false);
        $builder->setFontItalic(true);
        $builder->setFontColor(Color::DARKBLUE);

        $builder->setParagraphIndent(0, 0, 0);

        $builder->addText("Test Doc. Петяв ñáéíó\r\n");
        $builder->addNewLine(1);
        $builder->addText("\tStop.");

        $rtf2 = $builder->getRtf();
        $builder->save($this->getOutDir().'doc2.rtf');

        $this->assertEquals($this->loadResult('build-01.txt'), $rtf1, 'RtfDocument generated content matched');
        $this->assertEquals($this->loadResult('build-02.txt'), $rtf2, 'RtfDocument (unicode) generated content matched');
    }

    public function testCreateImage()
    {
        $builder = new Builder(new Document());

        $builder->getDocument()
            ->setCodepage(1252)
            ->setLcid(1057)
        ;

        $font = new Font();
        $font
            ->setName('Arial')
            ->setSize(10)
        ;
        $builder->updateFont($font);

        $builder->addText('Image Sample');
        $builder->addNewParagraph();
        $builder->addImage($this->getFixtureDir().'image1.png');

        $rtf = $builder->getRtf();
        $builder->save($this->getOutDir().'doc3.rtf');

        $this->assertEquals($this->loadResult('build-03.txt'), $rtf, 'RtfDocument with image generated content matched');
    }
}