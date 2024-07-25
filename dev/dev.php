<?php
/**
 * Simple Tests
 */

use PTag\ElementCf;
use PTag\HtmlFactory;

require_once __DIR__ . '/../vendor/autoload.php';

ElementCf::setMode(ElementCf::MODE_HTML5);

echo HtmlFactory::div()
    ->add('Some content')
    ->addClass(['test', 'b', 'a', ['another']])
    ->addClass('some funny classes')
    ->addClass('some funny classes')
    ->addClass('notshown')
    ->setAttributes([
        'test' => null,
    ]);




