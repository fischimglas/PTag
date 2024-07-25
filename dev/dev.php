<?php
/**
 * Simple Tests
 */

use PTag\ElementCf;
use PTag\HtmlFactory;

require_once __DIR__ . '/../vendor/autoload.php';

ElementCf::setMode(ElementCf::MODE_XHML);

echo HtmlFactory::empty()
    ->add('Some content')
    ->addClass('notshown');




