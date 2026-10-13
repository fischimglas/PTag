<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use PTag\ElementCf;
use PTag\HtmlFactory;
use ReflectionClass;
use ReflectionMethod;

class HtmlFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);
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

    public function testCommentEdgeCases()
    {
        self::assertEquals('<!-- a - -!> b -->', HtmlFactory::comment('a --!> b')->serialize());
        self::assertEquals('<!-- <!- - -->', HtmlFactory::comment('<!--')->serialize());
        self::assertEquals('<!-- -> x- -->', HtmlFactory::comment('-> x-')->serialize());
        self::assertEquals('<!--  -->', HtmlFactory::comment('')->serialize());
    }

    public function testDoctypeAndCommentInXhtmlMode()
    {
        ElementCf::setMode(ElementCf::MODE_XHTML);

        self::assertEquals('<!DOCTYPE html>', HtmlFactory::doctype()->serialize());
        self::assertEquals('<!-- a - - b -->', HtmlFactory::comment('a -- b')->serialize());
    }

    private const VOID_TAGS = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'source', 'track', 'wbr'];

    /**
     * Every tag method of HtmlFactory (all public static methods except the helpers)
     * @return array<string, array{string}>
     */
    public static function tagMethods(): array
    {
        $helpers = ['element', 'empty', 'text', 'doctype', 'comment'];
        $tags = [];
        foreach ((new ReflectionClass(HtmlFactory::class))->getMethods(ReflectionMethod::IS_STATIC) as $method) {
            if (!in_array($method->getName(), $helpers, true)) {
                $tags[$method->getName()] = [$method->getName()];
            }
        }

        return $tags;
    }

    /**
     * @dataProvider tagMethods
     */
    public function testTagMethodRendersItsTag(string $tag)
    {
        $element = HtmlFactory::$tag(['id' => 'x'], 'content');

        self::assertSame($tag, $element->getTag());
        if (in_array($tag, self::VOID_TAGS, true)) {
            self::assertSame("<$tag id=\"x\">", $element->serialize());
        } else {
            self::assertSame("<$tag id=\"x\">content</$tag>", $element->serialize());
        }
    }

    public function testFactoryCoversAllTags()
    {
        self::assertCount(115, self::tagMethods());
    }
}
