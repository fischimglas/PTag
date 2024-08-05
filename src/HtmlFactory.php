<?php

declare(strict_types=1);

namespace PTag;

class HtmlFactory
{

    public static function a(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function element(?string $elementName = null, ?array $attributes = [], $children = null): Element
    {
        return new Element($elementName, $attributes, $children);
    }

    public static function abbr(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function address(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function area(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function article(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function aside(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function audio(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function bdi(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function bdo(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function blockquote(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function body(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function button(?array $attributes = [], $children = null): Element
    {
        return new Element(__FUNCTION__, $attributes, $children);
    }

    public static function canvas(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function cite(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function code(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function col(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function colgroup(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function data(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function del(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function details(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function dfn(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function dialog(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function div(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function dl(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function dt(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function em(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function embed(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function empty($children = null): Element
    {
        return self::element(null, null, $children);
    }

    public static function figcaption(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function figure(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function footer(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function form(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function h1(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function h2(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function h3(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function h4(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function h5(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function h6(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function head(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function header(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function hgroup(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function html(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function i(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function iframe(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function img(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function input(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function ins(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function label(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function legend(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function li(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function link(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function main(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function map(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function mark(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function menu(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function meta(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function meter(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function nav(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function noscript(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function object(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function ol(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function optgroup(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function option(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function p(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function picture(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function pre(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function progress(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function search(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function section(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function select(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function slot(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function small(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function source(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function span(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function strong(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function style(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function sub(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function summary(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function sup(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function svg(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function table(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function tbody(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function td(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function template(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function textarea(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function th(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function thead(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function time(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function title(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function tr(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function track(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function u(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function ul(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function var(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    public static function video(?array $attributes = [], $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }
}
