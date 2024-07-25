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
        'command',
        'embed',
        'hr',
        'img',
        'input',
        'keygen',
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
     * @param $content
     */
    public function __construct(?string $tagName = null, ?array $attributes = [], $content = null)
    {
        $this->tag = $tagName ? strtolower($tagName) : null;
        if ($this->tag) {
            $this->setAttributes($attributes);
        }
        $this->add($content);
    }

    /**
     * @param array|null $attributes
     * @return Element
     */
    public function setAttributes(?array $attributes = []): self
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * @param null $content
     * @return Element
     */
    public function add(mixed $content = null): self
    {
        if ($content) {
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
            $value = $this->mergeCssClasses($value);
        }
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @param string|array|null $cssClasses
     * @return string
     */
    private function mergeCssClasses(null|string|array $cssClasses = []): string
    {
        $classes[] = $this->getClasses();
        if (!is_null($cssClasses)) {
            $classes[] = is_string($cssClasses) ? explode(' ', $cssClasses) : $cssClasses;
        }

        return implode(' ', array_filter(array_unique(array_merge(...$classes))));
    }

    public function getClasses(): array
    {
        return explode(' ', $this->attributes['class'] ?? '');
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
        $serializedAttributes = $this->serializeAttributes($this->attributes);
        $serializedStyle = $this->serializeStyle($this->style);
        $isSingletonTag = in_array($this->tag, self::SingletonTags);
        if ($this->tag) {
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
        } else {
            return $this->serializeContent($this->content);
        }
    }

    /**
     * Create attribute string from array
     * - Adds only the attribute name if the value is null
     * - Minimize attributes if value is null and HTML5 mode
     * - If attribute value is an array, serialize it, assuming it's css style
     * * @param array $attributes
     * @return string
     */
    private function serializeAttributes(array $attributes): string
    {
        $result = [];

        foreach ($attributes as $key => $value) {
            if (is_array($value)) {
                $valueItems = [];
                foreach ($value as $valueKey => $valueValue) {
                    $valueItems[] = $valueKey . ':' . $valueValue;
                }
                $value = implode(';', $valueItems);
            } elseif ($value instanceof SerializeableInterface) {
                $value = $value->serialize();
            }

            $result[] = $value === null && ElementCf::$attributeMinimization ? $key : $key . '="' . htmlentities($value . '') . '"';
        }

        return implode(' ', $result);
    }

    private function serializeStyle(array $styles): string
    {
        $result = [];

        foreach ($styles as $key => $value) {
            if (is_array($value)) {
                $value = $this->serializeStyle($value);
            } elseif ($value instanceof SerializeableInterface) {
                $value = $value->serialize();
            }

            $result[] = $key . ':' . htmlentities($value . '');
        }

        return implode(' ', $result);
    }

    /**
     * @param mixed $elements
     * @return string
     */
    private function serializeContent(mixed $elements): string
    {
        if (is_null($elements)) {
            return '';
        } elseif (is_string($elements) || is_bool($elements) || is_numeric($elements)) {
            return $elements;
        } elseif ($elements instanceof SerializeableInterface) {
            return $elements->serialize();
        } elseif (is_array($elements)) {
            return implode('', array_map(fn($it) => $this->serializeContent($it), $elements));
        } elseif (is_object($elements)) {
            return json_encode($elements);
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return $this->compile();
    }

    /**
     * @param string|array $className
     * @return Element
     */
    public function addClass(string|array $className): self
    {
        $this->setAttribute('class', $this->mergeCssClasses($className));

        return $this;
    }

    public function clone(): self
    {
        return clone $this;
    }

    /**
     * @param string|null $name
     * @return Element
     */
    public function removeAttribute(string $name = null): self
    {
        if (isset($this->attributes[$name])) {
            unset($this->attributes[$name]);
        }

        return $this;
    }

    /**
     * @param string $className
     * @return $this
     */
    public function removeClass(string $className): self
    {
        $classes = $this->getClasses();
        if (isset($classes[$className])) {
            unset($classes[$className]);
        }
        $this->setAttribute('class', implode(' ', $classes));

        return $this;
    }

    /**
     * @param string $name
     * @return Element
     */
    public function removeStyle(string $name): self
    {
        if (isset($this->style[$name])) {
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
        if (is_null($value)) {
            return $this;
        }

        $this->style[$name] = $value;

        return $this;
    }
}
