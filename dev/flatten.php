<?php
/**
 * Simple Tests
 */

use PTag\HtmlFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$a = [
    'some string',
    'jam' => 'some string',
    'nested' => [
        'lala' => 'jam',
        'baba' => 'jam',
        'kaka' => 'jam',
    ],
    'isTrue' => true,
    HtmlFactory::div(['class' => 'jam']),
];


