<?php

namespace NTLAB\RtfTree\Test;

use NTLAB\RtfTree\Node\Tree;

class ReplaceTest extends BaseTest
{
    protected $times = array();

    public function testFindText()
    {
        $tree = new Tree();
        $tree->loadFromFile($this->getFixtureDir().'test-repl-01.rtf');
        $nodes = $tree->getMainGroup()->findText('Italic');
        $this->saveOut($tree->toStringEx(), 'repl-01.txt');

        $this->assertEquals(2, count($nodes), 'Find for "Italic" has 2 occurance');

        $this->assertEquals($nodes[0], $tree->getMainGroup()->getChildAt(18), 'Node matched for occurance 1');
        $this->assertEquals('Bold Italic Underline Size 14', $nodes[0]->getKey(), 'First occurance matched');

        $this->assertEquals($nodes[1], $tree->getMainGroup()->getChildAt(62), 'Node matched for occurance 2');
        $this->assertEquals('Italic2', $nodes[1]->getKey(), '2nd occurance matched');
    }

    public function testReplaceText()
    {
        $tree = new Tree();
        $tree->loadFromFile($this->getFixtureDir().'test-repl-01.rtf');
        $tree->getMainGroup()->replaceText('Italic', 'REPLACED');

        $this->assertEquals($this->loadResult('repl-01.txt'), $tree->getRtf(), 'Replaced rtf matched');
    }

    protected function timedReplace(Tree $tree, $from, $to)
    {
        $time = microtime(true);
        $result = $tree->getMainGroup()->replaceTextEx($from, $to);
        $delta = microtime(true) - $time;
        $this->times[] = sprintf("Time for %s = %f", $from, $delta);

        return $result;
    }

    public function testReplaceTextEx()
    {
        $tree = new Tree();
        $tree->setIgnoreWhitespace(false);
        $tree->loadFromFile($this->getFixtureDir().'test-repl-02.rtf');
        $this->times[] = sprintf("Document loaded in %f", $tree->getParseTime());
        $this->saveOut($tree->toStringExTimed(), 'node-load-times.txt');

        $this->assertEquals(true, $this->timedReplace($tree, '<TAG1>', 'Tag 1'), 'Sucessfuly replaced tag whithin single node');
        $this->assertEquals(true, $this->timedReplace($tree, '<TAG2>', 'Tag 2'), 'Sucessfuly replaced tag adjacent to previous tag');
        $this->assertEquals(true, $this->timedReplace($tree, '<THIS_IS_A_TAG>', '{Replace TAG}'), 'Sucessfuly replaced tag across nodes');
        $this->assertEquals(true, $this->timedReplace($tree, '<REPLACE_ME>', 'Петяв ñáéíó'), 'Sucessfuly replaced encoded text');
        $this->assertEquals(true, $this->timedReplace($tree, '<MORE10>', ''), 'Sucessfuly replaced tag to empty');

        $this->saveOut(implode("\n", $this->times), 'times.txt');

        $this->assertEquals($this->loadResult('repl-02.txt'), $tree->getRtf(), 'Replaced content matched');
    }
}