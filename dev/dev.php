<?php
/**
 * Simple Tests
 */

use PTag\HtmlFactory;

require_once __DIR__ . '/../vendor/autoload.php';


$a = HtmlFactory::a(['href' => 'test']);
$a->setStyle('border-color', 'red');

echo $a;


