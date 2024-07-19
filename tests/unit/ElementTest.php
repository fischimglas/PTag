<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use PTag\Element;
use stdClass;

class ElementTest extends TestCase
{
    public function testElement()
    {
        $img = new Element('img');
        $img->setAttribute('src', 'google.com');

        $e = new Element('a', ['class' => 'red'], 'some content');
        $e->setAttributes(['href' => 'google.com']);
        $e->add('Some more content');
        $e->add($img);

        $expected = '<a class="red" href="google.com">some contentSome more content<img src="google.com"/></a>';
        $actual = $e->serialize();

        self::assertEquals($expected, $actual);
    }

    public function testEmptyAttribute()
    {
        $expected = '<div empty>My name is Sulaco</div>';

        $e = new Element('div', ['empty' => null]);
        $e->add('My name is Sulaco');

        $actual = $e->serialize();

        self::assertEquals($expected, $actual);
    }

    public function testStyleAttributeAsArray()
    {
        $expected = '<div style="color:black;background:red"></div>';

        $e = new Element('div', ['style' => ['color' => 'black', 'background' => 'red']]);

        $actual = $e->serialize();

        self::assertEquals($expected, $actual);
    }

    public function testDuplicateCssClass()
    {
        $expected = '<div class="mb-1 mb-2"></div>';

        $e = new Element('div', ['class' => ['mb-1', 'mb-2', 'mb-1']]);

        $actual = $e->serialize();

        self::assertEquals($expected, $actual);
    }

    public function testMultiTypeContent()
    {
        $expected = '<div class="test">text<a></a>text1text2{"a":1}</div>';

        $test = new StdClass();
        $test->a = 1;

        $e = new Element('div', ['class' => ['test']]);
        $e->add('text');
        $e->add(new Element('a'));
        $e->add([
            'text1',
            'text2',
            $test,
        ]);

        $actual = $e->serialize();

        self::assertEquals($expected, $actual);
    }

}
