<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use PTag\Element;
use PTag\ElementCf;
use PTag\HtmlFactory;
use stdClass;

class ElementTest extends TestCase
{
    protected function setUp(): void
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);
    }

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

        self::assertEquals('<input disabled aria-hidden="true" data-x="false">', $e->serialize());
    }

    public function testBooleanAttributesXhtml()
    {
        ElementCf::setMode(ElementCf::MODE_XHML);

        $e = new Element('input', ['disabled' => true, 'checked' => false]);

        self::assertEquals('<input disabled="disabled" />', $e->serialize());

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
        $e->addClass([7]);

        self::assertEquals('<div class="a 5 7"></div>', $e->serialize());
        self::assertEquals('<div class="8"></div>', $e->setAttribute('class', 8)->serialize());
    }

    public function testArrayStyleValue()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $e = new Element('div');
        $e->setStyle('margin', [0, 'auto']);

        self::assertEquals('<div style="margin:0 auto"></div>', $e->serialize());
    }

    public function testUnsafeNamesAreSanitized()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        $e = new Element('div', ['a"b' => 1, 'x onclick=alert(1)' => 2, '"><' => 3, 'data-ok' => 4, '@click' => 5]);
        $e->setStyle('color;background', 'red');
        $e->setStyle('--my-var', '1px');

        self::assertEquals(
            '<div ab="1" xonclickalert(1)="2" data-ok="4" @click="5" style="colorbackground:red;--my-var:1px"></div>',
            $e->serialize()
        );
    }

    public function testHtmlFactory()
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);

        self::assertEquals('<p class="x">a<br>b<b>c</b></p>', HtmlFactory::p(['class' => 'x'], ['a', HtmlFactory::br(), 'b', HtmlFactory::b([], 'c')])->serialize());
        self::assertEquals('<dl><dt>t</dt><dd>d</dd></dl>', HtmlFactory::dl([], [HtmlFactory::dt([], 't'), HtmlFactory::dd([], 'd')])->serialize());
        self::assertEquals('<hr>', HtmlFactory::hr()->serialize());
        self::assertEquals('<picture></picture>', HtmlFactory::picture()->serialize());
        self::assertEquals('<var></var>', HtmlFactory::var()->serialize());
        self::assertEquals('text<a></a>', HtmlFactory::empty(['text', HtmlFactory::a()])->serialize());
    }

    public function testXhtmlModeConstants()
    {
        self::assertSame(ElementCf::MODE_XHML, ElementCf::MODE_XHTML);

        ElementCf::setMode(ElementCf::MODE_XHTML);
        self::assertEquals('<br />', (new Element('br'))->serialize());

        ElementCf::setMode(ElementCf::MODE_HTML5);
        self::assertEquals('<br>', (new Element('br'))->serialize());
    }

    public function testSetAndRemoveStyle()
    {
        $e = new Element('div');
        $e->setStyle('color', 'red')->setStyle('background', 'blue')->setStyle('border', null);
        $e->removeStyle('color');
        $e->removeStyle(null);

        self::assertEquals('<div style="background:blue"></div>', $e->serialize());
    }

    public function testNullArgumentsAreIgnored()
    {
        $e = new Element('div', null, null);
        $e->setAttributes(null)->add(null)->addClass(null)->removeClass(null)->removeAttribute(null);

        self::assertEquals('<div></div>', $e->serialize());
    }

    public function testNestedClassArraysAndChaining()
    {
        $e = (new Element('div'))
            ->addClass(['a', ['b', ['c']]])
            ->addClass('c d')
            ->removeClass('a')
            ->setAttribute('tabindex', 1)
            ->setAttribute('hidden');

        self::assertEquals('<div class="b c d" tabindex="1" hidden></div>', $e->serialize());
    }

    public function testAttributeValuesAreEscaped()
    {
        $e = new Element('a', ['title' => '"><script>']);

        self::assertEquals('<a title="&quot;&gt;&lt;script&gt;"></a>', $e->serialize());
    }

    public function testSetAttributeClassReplaces()
    {
        $e = new Element('div', ['class' => 'a b']);
        $e->setAttribute('class', ['c', 'c', 'd']);
        self::assertEquals('<div class="c d"></div>', $e->serialize());

        $e->addClass('e');
        self::assertEquals('<div class="c d e"></div>', $e->serialize());

        $e->setAttribute('class', null);
        self::assertEquals('<div></div>', $e->serialize());
    }

    public function testObsoleteTagsAreNotVoid()
    {
        self::assertEquals('<keygen></keygen>', (new Element('keygen'))->serialize());
        self::assertEquals('<command></command>', (new Element('command'))->serialize());
    }

    public function testRemoveValuelessAttribute()
    {
        $e = (new Element('div'))->setAttribute('uk-img')->setAttribute('id', 'x');
        $e->removeAttribute('uk-img');

        self::assertEquals('<div id="x"></div>', $e->serialize());
    }

    public function testNonStringClassValues()
    {
        $stringable = new class {
            public function __toString(): string
            {
                return 'from-object';
            }
        };

        self::assertEquals('<div></div>', (new Element('div', ['class' => false]))->serialize());
        self::assertEquals('<div></div>', (new Element('div', ['class' => true]))->serialize());
        self::assertEquals('<div></div>', (new Element('div', ['class' => new stdClass()]))->serialize());
        self::assertEquals('<div class="from-object a"></div>', (new Element('div', ['class' => [$stringable, 'a', false]]))->serialize());
    }

    public function testStyleAttributeAndSetStyleAreMerged()
    {
        $e = new Element('div', ['style' => 'color:red;', 'id' => 'x']);
        $e->setStyle('margin', 0);
        self::assertEquals('<div id="x" style="color:red;margin:0"></div>', $e->serialize());

        $e = new Element('div', ['style' => ['color' => 'red']]);
        $e->setStyle('margin', 0);
        self::assertEquals('<div style="color:red;margin:0"></div>', $e->serialize());
    }

    public function testStringableAndUnencodableContent()
    {
        $stringable = new class {
            public function __toString(): string
            {
                return 'text';
            }
        };
        $unencodable = new stdClass();
        $unencodable->a = NAN;

        self::assertEquals('<p>text</p>', (new Element('p', [], $stringable))->serialize());
        self::assertEquals('<p></p>', (new Element('p', [], $unencodable))->serialize());
    }

    public function testClassNamedZero()
    {
        self::assertEquals('<div class="0 a"></div>', (new Element('div'))->addClass('0 a')->serialize());
    }

    public function testArrayAttributeValues()
    {
        $e = new Element('div', [
            'style' => ['margin' => [0, 'auto']],
            'rel' => ['noopener', 'noreferrer'],
            'data-x' => ['a' => ['b', 'c']],
        ]);

        self::assertEquals('<div rel="noopener noreferrer" data-x="a:b c" style="margin:0 auto"></div>', $e->serialize());
    }

    public function testInvalidModeKeepsCurrentMode()
    {
        try {
            ElementCf::setMode('xhtml');
            self::fail('Expected InvalidArgumentException');
        } catch (\InvalidArgumentException) {
        }

        self::assertEquals(ElementCf::MODE_HTML5, ElementCf::$mode);
        self::assertEquals('<br>', (new Element('br'))->serialize());
    }
}
