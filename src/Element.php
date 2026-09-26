<?php
/**
 * HTML Element
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

    /** @var array<string, mixed> */
    private array $attributes = [];
    /** @var array<string, mixed> */
    private array $style = [];
    /** @var list<mixed> */
    private array $content = [];
    private ?string $tag;

    /**
     * @param string|null $tagName tag name, null for a container without tag (only the content is rendered)
     * @throws \InvalidArgumentException if the name contains characters that are not allowed in tag names
     * @param array<array-key, mixed>|null $attributes see setAttributes()
     * @param mixed $content see add()
     */
    public function __construct(?string $tagName = null, ?array $attributes = [], mixed $content = null)
    {
        $this->tag = $this->normalizeTagName($tagName);
        $this->setAttributes($attributes);
        $this->add($content);
    }

    /**
     * Set several attributes. List entries without key are attributes without value:
     * ['required', 'type' => 'text'] renders required type="text"
     * @param array<array-key, mixed>|null $attributes
     * @return Element
     */
    public function setAttributes(?array $attributes = []): self
    {
        if (!is_null($attributes)) {
            foreach ($attributes as $key => $value) {
                if (is_int($key)) {
                    if (is_string($value) && $value !== '') {
                        $this->setAttribute($value);
                    }
                    continue;
                }
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }

    /**
     * Add child content, rendered as raw HTML (use addText() for escaped text).
     * Accepts elements, strings, numbers, Stringable objects and (nested) arrays of those; null is ignored.
     * @param mixed $content
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
     * Add text content, HTML special characters are escaped (use add() for raw HTML)
     * @param mixed $text string, number, Stringable or array of those; null and booleans add nothing
     * @return Element
     */
    public function addText(mixed $text): self
    {
        if (!is_null($text) && !is_bool($text)) {
            $this->content[] = $this->escape($this->stringify($text));
        }

        return $this;
    }

    /**
     * Set an attribute, replacing an existing value.
     * - null: attribute without value
     * - bool: see serializeAttributes()
     * - array: list joined with spaces, associative array as key:value;key:value
     * - 'class': string, number, Stringable or (nested) array of class names; empty removes the attribute
     * @param string $name
     * @param mixed $value
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

    /**
     * @param mixed $value
     * @return bool
     * @phpstan-assert-if-true string|int|float|\Stringable $value
     */
    private function isClassName(mixed $value): bool
    {
        return is_string($value) || is_int($value) || is_float($value) || $value instanceof \Stringable;
    }

    /**
     * @param array<array-key, mixed> $array
     * @return list<string>
     */
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
     * @return list<string>
     */
    public function getClasses(): array
    {
        return array_values(array_filter(explode(' ', $this->stringify($this->attributes['class'] ?? '')), fn($it) => $it !== ''));
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
     * @param array<string, mixed> $attributes
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
     * @param array<array-key, mixed> $styles
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
     * Add classes to the existing ones, duplicates are removed
     * @param string|array<array-key, mixed>|null $className space separated string or (nested) array of class names
     * @return Element
     */
    public function addClass(null|string|array $className): self
    {
        if (!is_null($className)) {
            $this->setAttribute('class', $this->mergeCssClasses($className));
        }

        return $this;
    }

    /**
     * @return Element deep copy, see __clone()
     */
    public function clone(): self
    {
        return clone $this;
    }

    /**
     * Deep clone: child elements are cloned as well, so the copy can be modified independently
     */
    public function __clone(): void
    {
        $this->content = array_map(fn($it) => $this->cloneContent($it), $this->content);
    }

    /**
     * @param mixed $content
     * @return mixed
     */
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
     * @param string|array<array-key, string>|null $className space separated string or array of class names
     * @return Element
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
     * Set an inline style. null is ignored; arrays are joined with spaces: ['margin', [0, 'auto']] renders margin:0 auto
     * @param string $name
     * @param mixed $value
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
     * Lowercase the tag name; null or '' means no tag
     * @param string|null $tagName
     * @return string|null
     * @throws \InvalidArgumentException if the name contains characters that are not allowed in tag names
     */
    private function normalizeTagName(?string $tagName): ?string
    {
        if ($tagName === null || $tagName === '') {
            return null;
        }
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9._:-]*$/', $tagName)) {
            throw new \InvalidArgumentException(sprintf('Invalid tag name "%s"', $tagName));
        }

        return strtolower($tagName);
    }

    /**
     * @param string|null $tagName null or '' removes the tag (only the content is rendered)
     * @return Element
     * @throws \InvalidArgumentException if the name contains characters that are not allowed in tag names
     */
    public function setTag(?string $tagName = null): self
    {
        $this->tag = $this->normalizeTagName($tagName);

        return $this;
    }

    /**
     * @return string|null lowercase tag name, null for a container without tag
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @param string $name
     * @return bool true if the attribute is set, also when it has no value
     */
    public function hasAttribute(string $name): bool
    {
        return array_key_exists($name, $this->attributes);
    }

    /**
     * @param string $name
     * @return mixed the value as it was set, null if the attribute has no value or is not set (see hasAttribute())
     */
    public function getAttribute(string $name): mixed
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * @return array<string, mixed> all attributes as they were set (without styles from setStyle())
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $className
     * @return bool
     */
    public function hasClass(string $className): bool
    {
        return in_array($className, $this->getClasses(), true);
    }

    /**
     * Add the class if it is missing, remove it if it is present.
     * With $force, true always adds and false always removes the class.
     * @param string $className
     * @param bool|null $force
     * @return Element
     */
    public function toggleClass(string $className, ?bool $force = null): self
    {
        $add = $force ?? !$this->hasClass($className);

        return $add ? $this->addClass($className) : $this->removeClass($className);
    }

    /**
     * Set several inline styles, see setStyle()
     * @param array<string, mixed>|null $styles
     * @return Element
     */
    public function setStyles(?array $styles = []): self
    {
        foreach ($styles ?? [] as $name => $value) {
            $this->setStyle((string)$name, $value);
        }

        return $this;
    }

    /**
     * @param string $name
     * @return mixed the value set with setStyle(), null if not set
     */
    public function getStyle(string $name): mixed
    {
        return $this->style[$name] ?? null;
    }

    /**
     * @return array<string, mixed> styles set with setStyle() (a 'style' attribute is returned by getAttribute('style'))
     */
    public function getStyles(): array
    {
        return $this->style;
    }

    /**
     * @return list<mixed> child content in order, as it was added (an array added with add() is one entry)
     */
    public function getChildren(): array
    {
        return $this->content;
    }

    /**
     * Add child content at the beginning, rendered as raw HTML, see add()
     * @param mixed $content
     * @return Element
     */
    public function prepend(mixed $content = null): self
    {
        if (!is_null($content)) {
            array_unshift($this->content, $content);
        }

        return $this;
    }

    /**
     * Remove all child content
     * @return Element
     */
    public function clearChildren(): self
    {
        $this->content = [];

        return $this;
    }
}
