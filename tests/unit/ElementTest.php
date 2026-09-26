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

    public function testGetClasses()
    {
        self::assertSame([], (new Element('div'))->getClasses());
        self::assertSame(['a', 'b'], (new Element('div', ['class' => 'a  b']))->getClasses());
        self::assertSame([], (new Element('div', ['class' => 'a']))->removeClass('a')->getClasses());
    }

    public function testNonAsciiAttributeValuesAreNotEntityEncoded()
    {
        $e = new Element('a', ['title' => 'Grüße € <&> \'x\'']);

        self::assertEquals('<a title="Grüße € &lt;&amp;&gt; &#039;x&#039;"></a>', $e->serialize());
    }

    public function testBooleanContentRendersNothing()
    {
        self::assertEquals('<div>0</div>', (new Element('div', [], [true, false, 0, null]))->serialize());
    }

    public function testTextIsEscaped()
    {
        self::assertEquals(
            '<p>&lt;b&gt;Tom &amp; Jerry&lt;/b&gt;</p>',
            HtmlFactory::p([], HtmlFactory::text('<b>Tom & Jerry</b>'))->serialize()
        );
        self::assertEquals(
            '<p>a &lt; b<br>1 2</p>',
            HtmlFactory::p()->addText('a < b')->add('<br>')->addText([1, 2])->addText(null)->addText(false)->serialize()
        );
    }

    public function testListEntriesAreValuelessAttributes()
    {
        self::assertEquals('<input required type="text">', HtmlFactory::input(['required', 'type' => 'text'])->serialize());
        self::assertEquals('<input>', HtmlFactory::input([5 => null, 6 => ''])->serialize());
    }

    public function testValidTagNames()
    {
        self::assertEquals('<my-widget>x</my-widget>', HtmlFactory::element('my-widget', [], 'x')->serialize());
        self::assertEquals('<svg:rect></svg:rect>', HtmlFactory::element('svg:rect')->serialize());
        self::assertEquals('<h1></h1>', HtmlFactory::element('H1')->serialize());
        self::assertEquals('x', HtmlFactory::element('', [], 'x')->serialize());
    }

    public function testInvalidTagNamesThrow()
    {
        foreach (['div onclick=alert(1)', '1div', 'div>', '<div', 'di"v', '-x'] as $name) {
            try {
                new Element($name);
                self::fail('Expected InvalidArgumentException for ' . $name);
            } catch (\InvalidArgumentException) {
            }

            try {
                (new Element('div'))->setTag($name);
                self::fail('Expected InvalidArgumentException in setTag() for ' . $name);
            } catch (\InvalidArgumentException) {
            }
        }
        self::assertTrue(true);
    }

    public function testGetTag()
    {
        self::assertSame('div', (new Element('DIV'))->getTag());
        self::assertNull((new Element())->getTag());
        self::assertSame('span', (new Element())->setTag('span')->getTag());
    }

    public function testAttributeGetters()
    {
        $e = new Element('input', ['type' => 'text', 'required', 'data-x' => false]);

        self::assertTrue($e->hasAttribute('type'));
        self::assertTrue($e->hasAttribute('required'));
        self::assertTrue($e->hasAttribute('data-x'));
        self::assertFalse($e->hasAttribute('name'));
        self::assertSame('text', $e->getAttribute('type'));
        self::assertNull($e->getAttribute('required'));
        self::assertFalse($e->getAttribute('data-x'));
        self::assertNull($e->getAttribute('name'));
        self::assertSame(['type' => 'text', 'required' => null, 'data-x' => false], $e->getAttributes());

        $e->removeAttribute('required');
        self::assertFalse($e->hasAttribute('required'));
    }

    public function testHasClass()
    {
        $e = new Element('div', ['class' => 'a b 0']);

        self::assertTrue($e->hasClass('a'));
        self::assertTrue($e->hasClass('0'));
        self::assertFalse($e->hasClass('c'));
        self::assertFalse($e->hasClass(''));
    }

    public function testToggleClass()
    {
        $e = new Element('div', ['class' => 'a']);

        $e->toggleClass('b');
        self::assertEquals('<div class="a b"></div>', $e->serialize());
        $e->toggleClass('a');
        self::assertEquals('<div class="b"></div>', $e->serialize());
        $e->toggleClass('b', true);
        self::assertEquals('<div class="b"></div>', $e->serialize());
        $e->toggleClass('c', false);
        self::assertEquals('<div class="b"></div>', $e->serialize());
        $e->toggleClass('b', false);
        self::assertEquals('<div></div>', $e->serialize());
    }

    public function testStyleGettersAndSetStyles()
    {
        $e = new Element('div', ['style' => 'color:red']);
        $e->setStyles(['margin' => 0, 'padding' => null, 'border' => '1px solid'])->setStyles(null);

        self::assertSame(0, $e->getStyle('margin'));
        self::assertNull($e->getStyle('padding'));
        self::assertSame(['margin' => 0, 'border' => '1px solid'], $e->getStyles());
        self::assertSame('color:red', $e->getAttribute('style'));
        self::assertEquals('<div style="color:red;margin:0;border:1px solid"></div>', $e->serialize());
    }

    public function testChildren()
    {
        $span = new Element('span');
        $e = new Element('div', [], 'b');
        $e->add([$span, 'c'])->prepend('a')->prepend(null);

        self::assertSame(['a', 'b', [$span, 'c']], $e->getChildren());
        self::assertEquals('<div>ab<span></span>c</div>', $e->serialize());

        $e->clearChildren()->add('new');
        self::assertSame(['new'], $e->getChildren());
        self::assertEquals('<div>new</div>', $e->serialize());
    }

    public function testNewFactoryTags()
    {
        self::assertEquals('<math><mi>x</mi></math>', HtmlFactory::math([], HtmlFactory::element('mi', [], 'x'))->serialize());
        self::assertEquals(
            '<select><button><selectedcontent></selectedcontent></button></select>',
            HtmlFactory::select([], HtmlFactory::button([], HtmlFactory::selectedcontent()))->serialize()
        );
    }

    public function testDoctype()
    {
        self::assertEquals(
            '<!DOCTYPE html><html lang="en"></html>',
            HtmlFactory::empty([HtmlFactory::doctype(), HtmlFactory::html(['lang' => 'en'])])->serialize()
        );
    }

    public function testComment()
    {
        self::assertEquals('<!-- note -->', HtmlFactory::comment('note')->serialize());
        self::assertEquals('<!-- a - -> <script> - - - -->', HtmlFactory::comment('a --> <script> ---')->serialize());
        self::assertEquals('<div><!-- x --></div>', HtmlFactory::div([], HtmlFactory::comment('x'))->serialize());
    }
}
