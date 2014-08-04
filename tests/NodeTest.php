<?php

namespace NTLAB\RtfTree\Test;

use NTLAB\RtfTree\Node\Node;
use NTLAB\RtfTree\Node\Nodes;

class NodeTest extends BaseTest
{
    public function testAdd()
    {
        $node1 = new Node();
        $this->assertEquals(0, count($node1->getChildren()), 'Newly created node should have zero child');
        $node2 = new Node();
        $node1->insertChild(0, $node2);
        $this->assertEquals(1, count($node1->getChildren()), 'Successfuly added one child');
        $this->assertEquals($node2, $node1->getChildAt(0), 'Added child should match indexed child nodes');
        $node3 = new Node();
        $node2->appendChild($node3);
        $this->assertEquals(1, count($node1->getChildren()), 'Successfuly added one child using ->appendChild()');
        $this->assertEquals($node3, $node2->getChildAt(0), 'Added child should match indexed child nodes added using ->appendChild()');
    }

    public function testString()
    {
        $node1 = Node::create(Node::KEYWORD, 'b', true, 3);
        $node2 = Node::create(Node::ROOT, '', false, 0);
        $this->assertEquals('Node: [Keyword, \'b\', true, 3]', (string) $node1, 'String representation matched');
        $this->assertEquals('Node: [Root, \'\', false, 0]', (string) $node2, 'String representation matched');
    }

    public function testPopulate()
    {
        $nodes = new Nodes();
        // test add
        $node1 = Node::create(Node::KEYWORD, 'b', true, 2);
        $nodes->add(Node::create(Node::KEYWORD, 'a', true, 1));
        $nodes->add($node1);
        $nodes->add(Node::create(Node::KEYWORD, 'c', true, 3));
        $nodes->add(Node::create(Node::KEYWORD, 'd', true, 4));
        $nodes->add(Node::create(Node::KEYWORD, 'e', true, 5));

        $this->assertEquals(5, count($nodes), 'List has 5 childs');
        $this->assertEquals($node1, $nodes[1], 'Added node has same object');

        // test insert
        $node2 = Node::create(Node::KEYWORD, 'f', false, 6);
        $nodes->insert(1, $node2);
        $this->assertEquals(6, count($nodes), 'List count matched after a node is inserted');
        $this->assertEquals('f', $nodes[1]->getKey(), 'Inserted node has same object');

        // test remove
        $nodes->removeAt(1);
        $this->assertEquals(5, count($nodes), 'List count matched after a node is removed');
        $this->assertEquals('b', $nodes[1]->getKey(), 'Object matched after a node is removed');
        $nodes->removeAt(1, 2);
        $this->assertEquals(3, count($nodes), 'List count matched after range of node is removed');
        $this->assertEquals('d', $nodes[1]->getKey(), 'Object matched after range of node is removed');
    }

    public function testIndex()
    {
        $nodes = new Nodes();

        $node1 = Node::create(Node::KEYWORD, 'c', true, 3);
        $nodes->add(Node::create(Node::KEYWORD, 'a', true, 1));
        $nodes->add(Node::create(Node::KEYWORD, 'b', true, 2));
        $nodes->add($node1);
        $nodes->add(Node::create(Node::KEYWORD, 'b', true, 4));
        $node2 = $node1->cloneNode();
        $nodes->add($node2);
        $nodes->add(Node::create(Node::KEYWORD, 'e', true, 6));

        // index by object
        $this->assertEquals(2, $nodes->indexOf($node1), 'Index of object matched');
        $this->assertEquals(null, $nodes->indexOf(new Node()), 'Index of non existent object should be NULL');
        $this->assertEquals(2, $nodes->indexOf($node1, 0), 'Index of object matched if start index specified');
        $this->assertEquals(null, $nodes->indexOf($node1, 5), 'Index of object should be NULL if start index specified and out of range');

        // index by node key
        $this->assertEquals(1, $nodes->getIndex('b'), 'Index of node key matched');
        $this->assertEquals(null, $nodes->getIndex('x'), 'Index of non existent node key should NULL');
        $this->assertEquals(1, $nodes->getIndex('b', 1), 'Index of node key matched if start index specified');
        $this->assertEquals(3, $nodes->getIndex('b', 2), 'Index of node key matched if start index specified');
        $this->assertEquals(null, $nodes->getIndex('x', 0), 'Index of node key should NULL if start index specified and out of range');
    }

    public function testTraversal()
    {
        $node = Node::create(Node::ROOT, 'root');;
        $group = Node::create(Node::GROUP, 'group');
        $first = Node::create(Node::KEYWORD, 'first');
        $second = Node::create(Node::KEYWORD, 'second');
        $third = Node::create(Node::KEYWORD, 'third');
        $group->appendChild($first);
        $group->appendChild($second);
        $group->appendChild($third);
        $node->appendChild($group);
        $group2 = Node::create(Node::GROUP, 'group2');
        $node->appendChild($group2);

        $this->assertEquals(1, $second->getNodeIndex(), 'Second node index matched');
        $this->assertEquals($first, $group->getFirstChild(), 'First child matched');
        $this->assertEquals($third, $group->getLastChild(), 'Last child matched');
        $this->assertEquals($second, $first->getNextSibling(), 'Next sibling matched');
        $this->assertEquals($second, $third->getPreviousSibling(), 'Previous sibling matched');

        $this->assertEquals($group, $node->getNextNode(), 'Next node for root matched');
        $this->assertEquals($first, $group->getNextNode(), 'Next node for group matched');
        $this->assertEquals($second, $first->getNextNode(), 'Next node for other matched');

        $this->assertEquals($node, $group->getPreviousNode(), 'Previous node for group matched');
        $this->assertEquals($third, $group2->getPreviousNode(), 'Previous node for group matched the last child of previous group');
        $this->assertEquals($second, $third->getPreviousNode(), 'Previous node for other matched');
    }
}