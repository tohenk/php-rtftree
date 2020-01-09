<?php

namespace NTLAB\RtfTree\Test;

use NTLAB\RtfTree\Node\Node;
use NTLAB\RtfTree\Node\Tree;

class SelectionTest extends BaseTest
{
    /**
     * @var \NTLAB\RtfTree\Node\Tree
     */
    protected $tree = null;

    /**
     * @var \NTLAB\RtfTree\Node\Node
     */
    protected $mgroup = null;

    protected function setUp(): void
    {
        $this->tree = new Tree();
        $this->tree->loadFromFile($this->getFixtureDir().'test-sel-01.rtf');
        $this->mgroup = $this->tree-> getMainGroup();
    }

    public function testSelectChildNodesByType()
    {
        $list1 = $this->mgroup->selectChildNodesTyped(Node::KEYWORD);   //48 nodes
        $list2 = $this->mgroup->selectChildNodesTyped(Node::CONTROL);   //3 nodes
        $list3 = $this->mgroup->selectChildNodesTyped(Node::GROUP);     //3 nodes

        $this->assertEquals(49, count($list1));
        $this->assertEquals(3, count($list2));
        $this->assertEquals(3, count($list3));

        $this->assertEquals($list1[5], $this->mgroup->getChildAt(8));   //viewkind
        $this->assertEquals('lang', $list1[22]->getKey());              //lang3082

        $this->assertEquals($list2[0], $this->mgroup->getChildAt(45));  //'233
        $this->assertEquals($list2[1], $this->mgroup->getChildAt(47));  //'241
        $this->assertEquals(241, $list2[1]->getParameter());            //'241

        $this->assertEquals($list3[0], $this->mgroup->getChildAt(5));
        $this->assertEquals('fonttbl', $list3[0]->getFirstChild()->getKey());
        $this->assertEquals($list3[1], $this->mgroup->getChildAt(6));
        $this->assertEquals('colortbl', $list3[1]->getFirstChild()->getKey());
        $this->assertEquals($list3[2], $this->mgroup->getChildAt(7));
        $this->assertEquals('*', $list3[2]->getChildAt(0)->getKey());
        $this->assertEquals('generator', $list3[2]->getChildAt(1)->getKey());
    }

    public function testSelectNodesByType()
    {
      $list1 = $this->mgroup->selectNodesTyped(Node::KEYWORD);  //68 nodes
      $list2 = $this->mgroup->selectNodesTyped(Node::CONTROL);  //4 nodes
      $list3 = $this->mgroup->selectNodesTyped(Node::GROUP);    //6 nodes

      $this->assertEquals(69, count($list1));
      $this->assertEquals(4, count($list2));
      $this->assertEquals(6, count($list3));

      $this->assertEquals($list1[5], $this->mgroup->getChildAt(5)->getFirstChild());    //fonttbl
      $this->assertEquals($list1[22], $this->mgroup->getChildAt(6)->getChildAt(7));     //green0
      $this->assertEquals('green', $list1[22]->getKey());                               //green0

      $this->assertEquals($list2[0], $this->mgroup->getChildAt(7)->getFirstChild());    //* generator
      $this->assertEquals($list2[1], $this->mgroup->getChildAt(45));                    //'233
      $this->assertEquals($list2[2], $this->mgroup->getChildAt(47));                    //'241
      $this->assertEquals(241, $list2[2]->getParameter());                              //'241

      $this->assertEquals($list3[0], $this->mgroup->getChildAt(5));
      $this->assertEquals('fonttbl', $list3[0]->getFirstChild()->getKey());
      $this->assertEquals($list3[3], $this->mgroup->getChildAt(5)->getChildAt(3));
      $this->assertEquals('f', $list3[3]->getFirstChild()->getKey());
      $this->assertEquals(2, $list3[3]->getFirstChild()->getParameter());
      $this->assertEquals($list3[5], $this->mgroup->getChildAt(7));
      $this->assertEquals('*', $list3[5]->getChildAt(0)->getKey());
      $this->assertEquals('generator', $list3[5]->getChildAt(1)->getKey());
    }

    public function testSelectSingleNodeByType()
    {
      $node1 = $this->mgroup->selectSingleNodeTyped(Node::KEYWORD); //rtf1
      $node2 = $this->mgroup->selectSingleNodeTyped(Node::CONTROL); //* generator
      $node3 = $this->mgroup->selectSingleNodeTyped(Node::GROUP);   //fonttbl

      $this->assertEquals($node1, $this->mgroup->getChildAt(0));
      $this->assertEquals('rtf', $node1->getKey());
      $this->assertEquals($node2, $this->mgroup->getChildAt(7)->getChildAt(0));
      $this->assertEquals('*', $node2->getKey());
      $this->assertEquals('generator', $node2->getNextSibling()->getKey());
      $this->assertEquals($node3, $this->mgroup->getChildAt(5));
      $this->assertEquals('fonttbl', $node3->getFirstChild()->getKey());
    }

    public function testSelectSingleChildNodeByType()
    {
      $node1 = $this->mgroup->selectSingleChildNodeTyped(Node::KEYWORD); //rtf1
      $node2 = $this->mgroup->selectSingleChildNodeTyped(Node::CONTROL); //'233
      $node3 = $this->mgroup->selectSingleChildNodeTyped(Node::GROUP);   //fonttbl

      $this->assertEquals($node1, $this->mgroup->getChildAt(0));
      $this->assertEquals('rtf', $node1->getKey());
      $this->assertEquals($node2, $this->mgroup->getChildAt(45));
      $this->assertEquals('\'', $node2->getKey());
      $this->assertEquals(233, $node2->getParameter());
      $this->assertEquals($node3, $this->mgroup->getChildAt(5));
      $this->assertEquals('fonttbl', $node3->getFirstChild()->getKey());
    }

    public function testSelectChildNodesByKeyword()
    {
      $list1 = $this->mgroup->selectChildNodes('fs');  //5 nodes
      $list2 = $this->mgroup->selectChildNodes('f');   //3 nodes

      $this->assertEquals(5, count($list1));
      $this->assertEquals(3, count($list2));

      $this->assertEquals($list1[0], $this->mgroup->getChildAt(17));
      $this->assertEquals($list1[1], $this->mgroup->getChildAt(22));
      $this->assertEquals($list1[2], $this->mgroup->getChildAt(25));
      $this->assertEquals($list1[3], $this->mgroup->getChildAt(43));
      $this->assertEquals($list1[4], $this->mgroup->getChildAt(77));

      $this->assertEquals($list2[0], $this->mgroup->getChildAt(16));
      $this->assertEquals($list2[1], $this->mgroup->getChildAt(56));
      $this->assertEquals($list2[2], $this->mgroup->getChildAt(76));
    }

    public function testSelectNodesByKeyword()
    {
      $list1 = $this->mgroup->selectNodes('fs');  //5 nodes
      $list2 = $this->mgroup->selectNodes('f');   //6 nodes

      $this->assertEquals(5, count($list1));
      $this->assertEquals(6, count($list2));

      $this->assertEquals($list1[0], $this->mgroup->getChildAt(17));
      $this->assertEquals($list1[1], $this->mgroup->getChildAt(22));
      $this->assertEquals($list1[2], $this->mgroup->getChildAt(25));
      $this->assertEquals($list1[3], $this->mgroup->getChildAt(43));
      $this->assertEquals($list1[4], $this->mgroup->getChildAt(77));

      $this->assertEquals($list2[0], $this->mgroup->getChildAt(5)->getChildAt(1)->getFirstChild());
      $this->assertEquals($list2[1], $this->mgroup->getChildAt(5)->getChildAt(2)->getFirstChild());
      $this->assertEquals($list2[2], $this->mgroup->getChildAt(5)->getChildAt(3)->getFirstChild());
      $this->assertEquals($list2[3], $this->mgroup->getChildAt(16));
      $this->assertEquals($list2[4], $this->mgroup->getChildAt(56));
      $this->assertEquals($list2[5], $this->mgroup->getChildAt(76));
    }

    public function testSelectSingleNodeByKeyword()
    {
      $node1 = $this->mgroup->selectSingleNode('fs');
      $node2 = $this->mgroup->selectSingleNode('f');

      $this->assertEquals($node1, $this->mgroup->getChildAt(17));
      $this->assertEquals($node2, $this->mgroup->getChildAt(5)->getChildAt(1)->getFirstChild());
    }

    public function testSelectSingleChildNodeByKeyword()
    {
      $node1 = $this->mgroup->selectSingleChildNode('fs');
      $node2 = $this->mgroup->selectSingleChildNode('f');

      $this->assertEquals($node1, $this->mgroup->getChildAt(17));
      $this->assertEquals($node2, $this->mgroup->getChildAt(16));
    }

    public function testSelectChildNodesByKeywordAndParam()
    {
      $list1 = $this->mgroup->selectChildNodes('fs', 24);  //2 nodes
      $list2 = $this->mgroup->selectChildNodes('f', 1);    //1 nodes

      $this->assertEquals(2, count($list1));
      $this->assertEquals(1, count($list2));

      $this->assertEquals($list1[0], $this->mgroup->getChildAt(22));
      $this->assertEquals($list1[1], $this->mgroup->getChildAt(43));

      $this->assertEquals($list2[0], $this->mgroup->getChildAt(56));
    }

    public function testSelectNodesByKeywordAndParam()
    {
      $list1 = $this->mgroup->selectNodes('fs', 24);  //2 nodes
      $list2 = $this->mgroup->selectNodes('f', 1);    //2 nodes

      $this->assertEquals(2, count($list1));
      $this->assertEquals(2, count($list2));

      $this->assertEquals($list1[0], $this->mgroup->getChildAt(22));
      $this->assertEquals($list1[1], $this->mgroup->getChildAt(43));

      $this->assertEquals($list2[0], $this->mgroup->getChildAt(5)->getChildAt(2)->getFirstChild());
      $this->assertEquals($list2[1], $this->mgroup->getChildAt(56));
    }

    public function testSelectSingleNodeByKeywordAndParam()
    {
      $node1 = $this->mgroup->selectSingleNode('fs', 24);
      $node2 = $this->mgroup->selectSingleNode('f', 1);

      $this->assertEquals($node1, $this->mgroup->getChildAt(22));
      $this->assertEquals($node2, $this->mgroup->getChildAt(5)->getChildAt(2)->getFirstChild());
    }

    public function testSelectSingleChildNodeByKeywordAndParam()
    {
      $node1 = $this->mgroup->selectSingleChildNode('fs', 24);
      $node2 = $this->mgroup->selectSingleChildNode('f', 1);

      $this->assertEquals($node1, $this->mgroup->getChildAt(22));
      $this->assertEquals($node2, $this->mgroup->getChildAt(56));
    }

    public function testSelectChildGroup()
    {
      $list1 = $this->mgroup->selectChildGroup('colortbl');  //1 node
      $list2 = $this->mgroup->selectChildGroup('f');         //0 nodes

      $this->assertEquals(1, count($list1));
      $this->assertEquals(0, count($list2));

      $this->assertEquals($list1[0], $this->mgroup->getChildAt(6));
    }

    public function testSelectGroup()
    {
      $list1 = $this->mgroup->selectGroup('colortbl');  //1 node
      $list2 = $this->mgroup->selectGroup('f');         //3 nodes

      $this->assertEquals(1, count($list1));
      $this->assertEquals(3, count($list2));

      $this->assertEquals($list1[0], $this->mgroup->getChildAt(6));

      $this->assertEquals($list2[0], $this->mgroup->getChildAt(5)->getChildAt(1));
      $this->assertEquals($list2[1], $this->mgroup->getChildAt(5)->getChildAt(2));
      $this->assertEquals($list2[2], $this->mgroup->getChildAt(5)->getChildAt(3));
    }

    public function testSelectSingleGroup()
    {
      $node1 = $this->mgroup->selectSingleGroup('f');
      $node2 = $this->mgroup->getChildAt(5)->selectSingleChildGroup('f');

      $this->assertEquals($node1, $this->mgroup->getChildAt(5)->getChildAt(1));
      $this->assertEquals($node2, $this->mgroup->getChildAt(5)->getChildAt(1));
    }

    public function testSelectSpecialGroup()
    {
      $list1 = $this->mgroup->selectChildGroup('generator');
      $list2 = $this->mgroup->selectChildGroup('generator', false);
      $list3 = $this->mgroup->selectChildGroup('generator', true);

      $list4 = $this->mgroup->selectGroup('generator');
      $list5 = $this->mgroup->selectGroup('generator', false);
      $list6 = $this->mgroup->selectGroup('generator', true);

      $node1 = $this->mgroup->selectSingleChildGroup('generator');
      $node2 = $this->mgroup->selectSingleChildGroup('generator', false);
      $node3 = $this->mgroup->selectSingleChildGroup('generator', true);

      $node4 = $this->mgroup->selectSingleGroup('generator');
      $node5 = $this->mgroup->selectSingleGroup('generator', false);
      $node6 = $this->mgroup->selectSingleGroup('generator', true);

      $this->assertEquals(0, count($list1));
      $this->assertEquals(0, count($list2));
      $this->assertEquals(1, count($list3));

      $this->assertEquals(0, count($list4));
      $this->assertEquals(0, count($list5));
      $this->assertEquals(1, count($list6));

      $this->assertEquals($node1, null);
      $this->assertEquals($node2, null);
      $this->assertNotEquals($node3, null);

      $this->assertEquals($node4, null);
      $this->assertEquals($node5, null);
      $this->assertNotEquals($node6, null);
    }

    public function testSelectSiblings()
    {
      $node1 = $this->mgroup->getChildAt(4);                //deflang3082
      $node2 = $this->mgroup->getChildAt(6)->getChildAt(2); //colortbl/red

      $n1 = $node1->selectSiblingTyped(Node::GROUP);
      $n2 = $node1->selectSibling('viewkind');
      $n3 = $node1->selectSibling('fs', 28);

      $n4 = $node2->selectSiblingTyped(Node::KEYWORD);
      $n5 = $node2->selectSibling('blue');
      $n6 = $node2->selectSibling('red', 255);

      $this->assertEquals($n1, $this->mgroup->getChildAt(5));
      $this->assertEquals($n2, $this->mgroup->getChildAt(8));
      $this->assertEquals($n3, $this->mgroup->getChildAt(17));

      $this->assertEquals($n4, $this->mgroup->getChildAt(6)->getChildAt(3));
      $this->assertEquals($n5, $this->mgroup->getChildAt(6)->getChildAt(4));
      $this->assertEquals($n6, $this->mgroup->getChildAt(6)->getChildAt(6));
    }
}