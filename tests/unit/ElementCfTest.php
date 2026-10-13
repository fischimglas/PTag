<?php

namespace unit;

use PHPUnit\Framework\TestCase;
use PTag\Element;
use PTag\ElementCf;

class ElementCfTest extends TestCase
{
    protected function setUp(): void
    {
        ElementCf::setMode(ElementCf::MODE_HTML5);
    }

    public function testXhtmlModeConstants()
    {
        self::assertSame(ElementCf::MODE_XHML, ElementCf::MODE_XHTML);

        ElementCf::setMode(ElementCf::MODE_XHTML);
        self::assertEquals('<br />', (new Element('br'))->serialize());

        ElementCf::setMode(ElementCf::MODE_HTML5);
        self::assertEquals('<br>', (new Element('br'))->serialize());
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
