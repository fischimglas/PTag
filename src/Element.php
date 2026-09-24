<?php
/**
 * HTMl Element
 */
declare(strict_types=1);

namespace PTag;

class Element implements SerializeableInterface
{
    private const SingletonTags = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr',
    ];

    private array $attributes = [];
    private array $style = [];
    private array $content = [];
    private ?string $tag;

    /**
     * @param string|null $tagName
     * @param array|null $attributes
     * @param mixed $content
     */
    public function __construct(?string $tagName = null, ?array $attributes = [], mixed $content = null)
    {
        $this->tag = $tagName ? strtolower($tagName) : null;
        $this->setAttributes($attributes);
        $this->add($content);
    }

    /**
     * @param array|null $attributes
     * @return Element
     */
    public function setAttributes(?array $attributes = []): self
    {
        if (!is_null($attributes)) {
            foreach ($attributes as $key => $value) {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }

    /**
     * @param null $content
     * @return Element
     */
    public function add(mixed $content = null): self
    {
        if (!is_null($content)) {
            $this->content[] = $content;
        }

        return $this;
    }

    /**
     * @param string $name
     * @param string|null $value
     * @return Element
     */
    public function setAttribute(string $name, mixed $value = null): self
    {
        if ($name === 'class') {
            unset($this->attributes['class']);
            $value = $this->mergeCssClasses($value);
            if ($value === '') {
                return $this;
            }
        }
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Merge classes into the existing ones. Booleans, null and non-stringable objects add nothing.
     * @param mixed $cssClasses
     * @return string
     */
    private function mergeCssClasses(mixed $cssClasses = []): string
    {
        $newClasses = [];
        if (is_array($cssClasses)) {
            $newClasses = $this->flattenNestedArray($cssClasses);
        } elseif ($this->isClassName($cssClasses)) {
            $newClasses = explode(' ', (string)$cssClasses);
        }

        $classes = array_filter(array_merge($this->getClasses(), $newClasses), fn($it) => $it !== '');

        return implode(' ', array_unique($classes));
    }

    private function isClassName(mixed $value): bool
    {
        return is_string($value) || is_int($value) || is_float($value) || $value instanceof \Stringable;
    }

    private function flattenNestedArray(array $array): array
    {
        $result = [];
        foreach ($array as $value) {
            if (is_array($value)) {
                $result[] = $this->flattenNestedArray($value);
            } elseif ($this->isClassName($value)) {
                $result[] = explode(' ', (string)$value);
            }
        }

        return array_merge(...$result);
    }

    /**
     * @return array
     */
    public function getClasses(): array
    {
        return array_values(array_filter(explode(' ', (string)($this->attributes['class'] ?? '')), fn($it) => $it !== ''));
    }

    public function __toString(): string
    {
        return $this->compile();
    }

    /**
     * @return string
     */
    private function compile(): string
    {
        $tag = [];
        $attributes = $this->attributes;
        $styleAttribute = $attributes['style'] ?? null;
        unset($attributes['style']);
        $serializedAttributes = $this->serializeAttributes($attributes);
        $serializedStyle = implode(';', array_filter([
            $this->serializeStyleAttribute($styleAttribute),
            $this->serializeStyle($this->style),
        ], fn($it) => $it !== ''));
        $isSingletonTag = in_array($this->tag, self::SingletonTags);
        if (!$this->tag) {
            return $this->serializeContent($this->content);
        }

        $tag[] = '<' . $this->tag;
        if ($serializedAttributes) {
            $tag[] = ' ' . $serializedAttributes;
        }
        if ($serializedStyle) {
            $tag[] = ' style="' . $serializedStyle . '"';
        }

        if ($isSingletonTag) {
            $tag[] = (ElementCf::$trailingSlashesForVoidElements ? ' /' : '') . '>';
        } else {
            $tag[] = '>';
            if ($this->content) {
                $tag[] = $this->serializeContent($this->content);
            }
            $tag[] = '</' . $this->tag . '>';
        }

        return implode('', $tag);
    }

    /**
     * Serialize the value of a 'style' attribute (string or array), so it can be combined with setStyle() values
     * @param mixed $value
     * @return string
     */
    private function serializeStyleAttribute(mixed $value): string
    {
        if (is_array($value)) {
            return $this->serializeStyle($value);
        }

        return rtrim(trim($this->escape(is_bool($value) ? '' : $this->stringify($value))), ';');
    }

    /**
     * Escape special characters (& < > " ') for use in attribute values. Other characters are left as they are.
     * @param string $value
     * @return string
     */
    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Convert a value to string: arrays are joined with spaces, booleans become "true" / "false",
     * objects that can't be converted become ''
     * @param mixed $value
     * @return string
     */
    private function stringify(mixed $value): string
    {
        if ($value instanceof SerializeableInterface) {
            return $value->serialize();
        } elseif (is_array($value)) {
            return implode(' ', array_map(fn($it) => $this->stringify($it), $value));
        } elseif (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_scalar($value) || $value instanceof \Stringable) {
            return (string)$value;
        }

        return '';
    }

    /**
     * Create attribute string from array
     * - Adds only the attribute name if the value is null
     * - Minimize attributes if value is null and HTML5 mode
     * - Array values: lists are joined with spaces, associative arrays become key:value;key:value
     * - Boolean values: false omits the attribute, true renders it minimized (HTML5) or as name="name" (XHTML)
     * - aria-* and data-* booleans render as "true" / "false"
     * @param array $attributes
     * @return string
     */
    private function serializeAttributes(array $attributes): string
    {
        $result = [];

        foreach ($attributes as $key => $value) {
            $key = $this->sanitizeAttributeName((string)$key);
            if ($key === '') {
                continue;
            }

            if (is_bool($value)) {
                if ($this->isStringAttribute($key)) {
                    $value = $value ? 'true' : 'false';
                } elseif ($value === false) {
                    continue;
                } else {
                    $value = ElementCf::$attributeMinimization ? null : $key;
                }
            }

            if (is_array($value) && !array_is_list($value)) {
                $value = implode(';', array_map(
                    fn($vKey, $vValue) => $vKey . ':' . $this->stringify($vValue),
                    array_keys($value),
                    $value
                ));
            } elseif ($value !== null) {
                $value = $this->stringify($value);
            }

            $result[] = $value === null && ElementCf::$attributeMinimization ? $key : $key . '="' . $this->escape($value ?? '') . '"';
        }

        return implode(' ', $result);
    }

    /**
     * Remove characters that are not allowed in attribute names (whitespace, quotes, <, >, /, =, control chars)
     * @param string $name
     * @return string
     */
    private function sanitizeAttributeName(string $name): string
    {
        return preg_replace('/[\s"\'<>\/=\x00-\x1F\x7F]+/u', '', $name) ?? '';
    }

    /**
     * Allow only characters valid in CSS property names (incl. custom properties like --my-var)
     * @param string $name
     * @return string
     */
    private function sanitizeStyleName(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9_-]+/', '', $name) ?? '';
    }

    /**
     * aria-* and data-* attributes carry string values, booleans render as "true" / "false"
     * @param string $name
     * @return bool
     */
    private function isStringAttribute(string $name): bool
    {
        return str_starts_with($name, 'aria-') || str_starts_with($name, 'data-');
    }

    /**
     * @param array $styles
     * @return string
     */
    private function serializeStyle(array $styles): string
    {
        $result = [];
        $styles = array_filter($styles, fn($value) => $value !== null && $value !== '' && $value !== false);
        foreach ($styles as $key => $value) {
            $key = $this->sanitizeStyleName((string)$key);
            if ($key === '') {
                continue;
            }

            $result[] = $key . ':' . $this->escape($this->stringify($value));
        }

        return implode(';', $result);
    }

    /**
     * @param mixed $elements
     * @return string
     */
    private function serializeContent(mixed $elements): string
    {
        if (is_null($elements) || is_bool($elements)) {
            return '';
        } elseif (is_string($elements) || is_numeric($elements)) {
            return $elements . '';
        } elseif ($elements instanceof SerializeableInterface) {
            return $elements->serialize();
        } elseif (is_array($elements)) {
            return implode('', array_map(fn($it) => $this->serializeContent($it), $elements));
        } elseif ($elements instanceof \Stringable) {
            return (string)$elements;
        } elseif (is_object($elements)) {
            return json_encode($elements) ?: '';
        }

        return '';
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return $this->compile();
    }

    /**
     * @param string|array|null $className
     * @return Element
     */
    public function addClass(null|string|array $className): self
    {
        if (!is_null($className)) {
            $this->setAttribute('class', $this->mergeCssClasses($className));
        }

        return $this;
    }

    public function clone(): self
    {
        return clone $this;
    }

    /**
     * Deep clone: child elements are cloned as well, so the copy can be modified independently
     */
    public function __clone(): void
    {
        $this->content = $this->cloneContent($this->content);
    }

    private function cloneContent(mixed $content): mixed
    {
        if ($content instanceof self) {
            return clone $content;
        } elseif (is_array($content)) {
            return array_map(fn($it) => $this->cloneContent($it), $content);
        }

        return $content;
    }

    /**
     * @param string|array|null $className
     * @return $this
     */
    public function removeClass(null|string|array $className = null): self
    {
        if (is_string($className)) {
            $className = explode(' ', $className);
        }

        if (is_array($className)) {
            $existingClasses = array_flip($this->getClasses());
            foreach ($className as $currentClass) {
                if (isset($existingClasses[$currentClass])) {
                    unset($existingClasses[$currentClass]);
                }
            }

            $classString = implode(' ', array_keys($existingClasses));
            if (strlen($classString)) {
                $this->attributes['class'] = implode(' ', array_keys($existingClasses));
            } else {
                $this->removeAttribute('class');
            }
        }

        return $this;
    }

    /**
     * @param string|null $name
     * @return Element
     */
    public function removeAttribute(?string $name = null): self
    {
        if (!is_null($name) && array_key_exists($name, $this->attributes)) {
            unset($this->attributes[$name]);
        }

        return $this;
    }

    /**
     * @param string|null $name
     * @return Element
     */
    public function removeStyle(?string $name = null): self
    {
        if (!is_null($name) && isset($this->style[$name])) {
            unset($this->style[$name]);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return Element
     */
    public function setStyle(string $name, mixed $value): self
    {
        if (!is_null($value)) {
            $this->style[$name] = $value;
        }

        return $this;
    }

    /**
     * @param string|null $tagName
     * @return $this
     */
    public function setTag(?string $tagName = null): self
    {
        $this->tag = $tagName ? strtolower($tagName) : null;

        return $this;
    }
}
