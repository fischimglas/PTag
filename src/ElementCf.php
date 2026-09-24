<?php
declare(strict_types=1);

namespace PTag;

class ElementCf
{
    public const MODE_HTML5 = 'html5';
    public const MODE_XHTML = 'xhml';
    /** @deprecated use MODE_XHTML (kept for backwards compatibility) */
    public const MODE_XHML = self::MODE_XHTML;

    public static string $mode = self::MODE_HTML5;
    public static bool $trailingSlashesForVoidElements = false;
    public static bool $attributeMinimization = true;

    public static function setMode(string $mode): void
    {
        match ($mode) {
            self::MODE_HTML5 => self::configureModeHtml5(),
            self::MODE_XHTML => self::configureModeXhtml(),
            default => throw new \InvalidArgumentException(
                sprintf('Unknown mode "%s", use ElementCf::MODE_HTML5 or ElementCf::MODE_XHTML', $mode)
            ),
        };
        self::$mode = $mode;
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
