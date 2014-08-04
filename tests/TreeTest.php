<?php

namespace NTLAB\RtfTree\Test;

use NTLAB\RtfTree\Node\Node;
use NTLAB\RtfTree\Node\Tree;

class TreeTest extends BaseTest
{
    public function testCreateText()
    {
        $text = "Test Doc. {Петяв ñáéíó}\r\n";
        $nodes = Node::createText($text);
        //$this->saveOut(var_export($nodes, true), 'text-nodes.txt');

        $tree = new Tree();
        $main = $tree
            ->addMainGroup()
            ->getMainGroup();
        $main->appendChilds($nodes);

        $this->assertEquals(19, count($nodes), 'CreateText sucessfully creates 19 items');
        $this->assertEquals($this->loadResult('tree-01.txt'), $tree->getRtf(), 'CreateText generated rtf is matched');

        $nodes = Node::createText($text, true);
        $this->assertEquals(20, count($nodes), 'CreateText sucessfully creates 21 items with separated special chars');
    }

    public function testTextExtraction()
    {
        $tree = new Tree();
        $tree->loadFromFile($this->getFixtureDir().'test-tree-01.rtf');
        //$this->saveOut($tree->getRoot()->getRawText(), 'test-tree-01.txt');

        $simpleGroup = $tree->getMainGroup()->selectSingleGroup('ul');
        $nestedGroups = $tree->getMainGroup()->selectSingleGroup('cf');
        $keyword = $tree->getMainGroup()->selectSingleChildNode('b');
        $control = $tree->getMainGroup()->selectSingleChildNode('\'');
        $root = $tree->getRoot();

        $this->assertEquals('underline1', $simpleGroup->getNodeText());
        $this->assertEquals('blue1 luctus. Fusce in interdum ipsum. Cum sociis natoque penatibus et italic1 dis parturient montes, nascetur ridiculus mus.', $nestedGroups->getNodeText());
        $this->assertEquals('', $keyword->getNodeText());
        $this->assertEquals('é', $control->getNodeText());
        $this->assertEquals('', $root->getNodeText());

        $this->assertEquals('underline1', $simpleGroup->getRawText());
        $this->assertEquals('blue1 luctus. Fusce in interdum ipsum. Cum sociis natoque penatibus et italic1 dis parturient montes, nascetur ridiculus mus.', $nestedGroups->getRawText());
        $this->assertEquals('', $keyword->getRawText());
        $this->assertEquals('é', $control->getRawText());
        $this->assertEquals('', $root->getRawText());

        $fontsGroup = $tree->getMainGroup()->selectSingleGroup('fonttbl');
        $generatorGroup = $tree->getMainGroup()->selectSingleGroup('*');

        $this->assertEquals('', $fontsGroup->getNodeText());
        $this->assertEquals('', $generatorGroup->getNodeText());

        $this->assertEquals('Times New Roman;Arial;Arial;', $fontsGroup->getRawText());
        $this->assertEquals('Msftedit 5.41.15.1515;', $generatorGroup->getRawText());
    }

    public function testTextExtractionSpecial()
    {
        $tree = new Tree();
        $tree->loadFromFile($this->getFixtureDir().'test-tree-02.rtf');
        //$this->saveOut($tree->getText(), 'test-tree-02.txt');

        $this->assertEquals('Esto es una ‘prueba’'."\r\n\t".' y otra “prueba” y otra—prueba.'."\r\n", $tree->getText());
        $this->assertEquals('Esto es una ‘prueba’'."\r\n\t".' y otra “prueba” y otra—prueba.'."\r\n", $tree->getMainGroup()->getNodeText());
        $this->assertEquals('Arial;Msftedit 5.41.15.1515;Esto es una ‘prueba’'."\r\n\t".' y otra “prueba” y otra—prueba.'."\r\n", $tree->getMainGroup()->getRawText());
    }

    public function testTextExtractionUnicode()
    {
        $tree = new Tree();
        $tree->loadFromFile($this->getFixtureDir().'test-tree-03.rtf');
        //$this->saveOut($tree->getRoot()->getRawText(), 'test-tree-03.txt');

        $this->assertEquals('Prueba Unicode: Вова Петя'."\r\n".'Sin ignorar caracteres: Вова Петя'."\r\n", $tree->getText());
    }
}