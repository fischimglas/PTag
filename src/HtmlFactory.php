<?php

declare(strict_types=1);

namespace PTag;

class HtmlFactory
{

    /**
     * <a> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function a(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * Create any element, e.g. HtmlFactory::element('custom-tag', ['id' => 'x'], 'content')
     * @param string|null $elementName
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function element(?string $elementName = null, ?array $attributes = [], mixed $children = null): Element
    {
        return new Element($elementName, $attributes, $children);
    }

    /**
     * <abbr> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function abbr(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <address> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function address(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <area> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function area(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <article> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function article(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <aside> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function aside(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <audio> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function audio(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <b> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function b(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <base> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function base(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <bdi> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function bdi(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <bdo> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function bdo(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <blockquote> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function blockquote(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <body> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function body(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <br> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function br(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <button> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function button(?array $attributes = [], mixed $children = null): Element
    {
        return new Element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <canvas> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function canvas(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <caption> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function caption(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <cite> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function cite(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <code> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function code(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * HTML comment <!-- text -->. '--' in the text is split to '- -', so the comment can't be closed early.
     */
    public static function comment(string $text): Element
    {
        return self::empty('<!-- ' . preg_replace('/-(?=-)/', '- ', $text) . ' -->');
    }

    /**
     * <col> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function col(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <colgroup> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function colgroup(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <data> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function data(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <datalist> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function datalist(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <dd> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function dd(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <!DOCTYPE html>, e.g. HtmlFactory::empty([HtmlFactory::doctype(), HtmlFactory::html([], ...)])
     */
    public static function doctype(): Element
    {
        return self::empty('<!DOCTYPE html>');
    }

    /**
     * <del> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function del(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <details> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function details(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <dfn> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function dfn(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <dialog> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function dialog(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <div> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function div(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <dl> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function dl(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <dt> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function dt(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <em> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function em(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <embed> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function embed(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * Container without tag, only the children are rendered
     * @param mixed $children see Element::add()
     */
    public static function empty(mixed $children = null): Element
    {
        return self::element(null, null, $children);
    }

    /**
     * <fieldset> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function fieldset(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <figcaption> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function figcaption(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <figure> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function figure(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <footer> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function footer(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <form> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function form(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <h1> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function h1(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <h2> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function h2(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <h3> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function h3(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <h4> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function h4(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <h5> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function h5(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <h6> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function h6(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <head> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function head(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <header> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function header(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <hgroup> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function hgroup(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <hr> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function hr(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <html> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function html(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <i> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function i(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <iframe> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function iframe(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <img> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function img(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <input> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function input(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <ins> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function ins(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <kbd> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function kbd(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <label> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function label(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <legend> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function legend(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <li> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function li(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <link> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function link(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <main> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function main(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <map> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function map(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <mark> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function mark(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <math> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function math(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <menu> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function menu(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <meta> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function meta(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <meter> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function meter(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <nav> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function nav(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <noscript> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function noscript(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <object> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function object(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <ol> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function ol(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <optgroup> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function optgroup(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <option> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function option(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <output> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function output(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <p> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function p(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <picture> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function picture(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <pre> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function pre(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <progress> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function progress(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <q> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function q(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <rp> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function rp(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <rt> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function rt(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <ruby> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function ruby(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <s> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function s(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <samp> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function samp(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <script> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function script(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <search> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function search(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <section> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function section(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <select> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function select(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <selectedcontent> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function selectedcontent(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <slot> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function slot(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <small> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function small(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <source> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function source(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <span> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function span(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <strong> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function strong(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <style> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function style(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <sub> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function sub(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <summary> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function summary(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <sup> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function sup(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <svg> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function svg(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <table> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function table(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <tbody> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function tbody(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <td> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function td(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <template> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function template(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * Escaped text without a surrounding tag, e.g. HtmlFactory::p([], HtmlFactory::text($userInput))
     */
    public static function text(mixed $text): Element
    {
        return (new Element())->addText($text);
    }

    /**
     * <textarea> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function textarea(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <tfoot> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function tfoot(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <th> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function th(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <thead> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function thead(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <time> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function time(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <title> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function title(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <tr> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function tr(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <track> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function track(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <u> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function u(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <ul> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function ul(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <var> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function var(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <video> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function video(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }

    /**
     * <wbr> element
     * @param array<array-key, mixed>|null $attributes see Element::setAttributes()
     * @param mixed $children see Element::add()
     */
    public static function wbr(?array $attributes = [], mixed $children = null): Element
    {
        return self::element(__FUNCTION__, $attributes, $children);
    }
}
