<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use PTag\Element;
use PTag\ElementCf;
use stdClass;

class ElementTest extends TestCase
{
    public function testDuplicateCssClass()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $expected = '<div class="mb-1 mb-2"></div>';

        $e = new Element('div', ['class' => ['mb-1', 'mb-2', 'mb-1']]);

        $actual = $e->serialize();

        self::assertEquals($expected, $actual);
    }

    public function testElementHtml5()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $img = new Element('img');
        $img->setAttribute('src', 'google.com');

        $e = new Element('a', ['class' => 'red'], 'some content');
        $e->setAttributes(['href' => 'google.com']);
        $e->add('Some more content');
        $e->add($img);

        $expected = '<a class="red" href="google.com">some contentSome more content<img src="google.com"></a>';
        $actual = $e->serialize();

        self::assertEquals($expected, $actual);
    }

    public function testElementXhtml()
    {
        ElementCf::setMode(ElementCf::MODE_XHML);

        $img = new Element('img');
        $img->setAttribute('src', 'google.com');

        $e = new Element('a', ['class' => 'red'], 'some content');
        $e->setAttributes(['href' => 'google.com', 'lang' => null]);
        $e->add('Some more content');
        $e->add($img);

        $expected = '<a class="red" href="google.com" lang="">some contentSome more content<img src="google.com" /></a>';
        $actual = $e->serialize();

        self::assertEquals($expected, $actual);
    }

    public function testEmptyAttribute()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $expected = '<div empty>My name is frank</div>';

        $e = new Element('div', ['empty' => null]);
        $e->add('My name is frank');

        $actual = $e->serialize();

        self::assertEquals($expected, $actual);
    }

    public function testMultiTypeContent()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

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

    public function testRemoveAttribute()
    {
        $e = new Element('div');
        $e->setAttribute('alt', 'test');
        $e->removeAttribute('alt');

        $actual = $e->serialize();

        $expected = '<div></div>';
        self::assertEquals($expected, $actual);
    }

    public function testRemoveClass()
    {
        $e = new Element('div');
        $e->addClass('test');
        $e->removeClass('test');

        $actual = $e->serialize();

        $expected = '<div></div>';
        self::assertEquals($expected, $actual);
    }

    public function testRemoveClasses()
    {
        $e = new Element('div');
        $e->addClass('test test2 test3 test4 test5 test6');
        $e->removeClass('test test2 test3');
        $e->removeClass(['test4', 'test5']);

        $actual = $e->serialize();

        $expected = '<div class="test6"></div>';
        self::assertEquals($expected, $actual);
    }

    public function testStyleAttributeAsArray()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $expected = '<div style="color:black;background:red"></div>';

        $e = new Element('div', ['style' => ['color' => 'black', 'background' => 'red']]);

        $actual = $e->serialize();

        self::assertEquals($expected, $actual);
    }

    public function testStyleZeroValueIsKept()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $e = new Element('div');
        $e->setStyle('opacity', 0);
        $e->setStyle('margin', '0');
        $e->setStyle('padding', '');

        self::assertEquals('<div style="opacity:0;margin:0"></div>', $e->serialize());
    }

    public function testBooleanAttributesHtml5()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $e = new Element('input', ['disabled' => true, 'checked' => false, 'aria-hidden' => true, 'data-x' => false]);

        self::assertEquals('<input disabled aria-hidden="1" data-x="">', $e->serialize());
    }

    public function testBooleanAttributesXhtml()
    {
        ElementCf::setMode(ElementCf::MODE_XHML);

        $e = new Element('input', ['disabled' => true, 'checked' => false]);

        self::assertEquals('<input disabled="" />', $e->serialize());

        ElementCf::setMode(ElementCf::MODE_HTML5);
    }

    public function testCloneIsDeep()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $child = new Element('span');
        $nested = new Element('b');
        $original = new Element('div', [], $child);
        $original->add([$nested]);

        $copy = $original->clone();
        $child->addClass('changed');
        $nested->addClass('changed');

        self::assertEquals('<div><span></span><b></b></div>', $copy->serialize());
        self::assertEquals('<div><span class="changed"></span><b class="changed"></b></div>', $original->serialize());
    }

    public function testSetTagIsLowercased()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        self::assertEquals('<div></div>', (new Element('span'))->setTag('DIV')->serialize());
        self::assertEquals('<img>', (new Element('span'))->setTag('IMG')->serialize());
        self::assertEquals('text', (new Element('span', [], 'text'))->setTag('')->serialize());
    }

    public function testTaglessElementKeepsAttributes()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $e = new Element(null, ['id' => 'x', 'class' => 'a'], 'content');

        self::assertEquals('content', $e->serialize());
        self::assertEquals('<div id="x" class="a">content</div>', $e->setTag('div')->serialize());
    }

    public function testNumericClassNames()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $e = new Element('div', ['class' => ['a', 5]]);
        $e->setAttribute('class', 7);

        self::assertEquals('<div class="a 5 7"></div>', $e->serialize());
    }

    public function testArrayStyleValue()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $e = new Element('div');
        $e->setStyle('margin', [0, 'auto']);

        self::assertEquals('<div style="margin:0 auto"></div>', $e->serialize());
    }
}
