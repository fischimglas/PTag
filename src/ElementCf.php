<?php
declare(strict_types=1);

namespace PTag;

class ElementCf
{
    public const MODE_HTML5 = 'html5';
    public const MODE_XHML = 'xhml';

    public static string $mode = self::MODE_HTML5;
    public static bool $trailingSlashesForVoidElements = false;
    public static bool $attributeMinimization = true;

    public static function setMode(string $mode): void
    {
        self::$mode = $mode;
        match ($mode) {
            self::MODE_HTML5 => self::configureModeHtml5(),
            self::MODE_XHML => self::configureModeXhtml()
        };
    }

    private static function configureModeHtml5(): void
    {
        self::$trailingSlashesForVoidElements = false;
        self::$attributeMinimization = true;
    }

    private static function configureModeXhtml(): void
    {
        self::$trailingSlashesForVoidElements = true;
        self::$attributeMinimization = false;
    }
}
