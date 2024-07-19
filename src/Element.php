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
    private array $content = [];
    private ?string $tag;

    /**
     * @param string|null $tagName
     * @param array|null $attributes
     * @param $content
     */
    public function __construct(?string $tagName = null, ?array $attributes = null, $content = null)
    {
        $this->tag = $tagName ? strtolower($tagName) : null;
        if ($attributes !== null) {
            $this->setAttributes($attributes);
        }
        $this->add($content);
    }

    public function __toString(): string
    {
        return $this->compile();
    }

    /**
     * @param null $content
     * @return Element
     */
    public function add($content = null): self
    {
        if ($content) {
            $this->content[] = $content;
        }

        return $this;
    }

    public function clone(): self
    {
        return clone $this;
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return $this->compile();
    }

    /**
     * @param string|null $name
     * @param string|null $value
     * @return Element
     */
    public function setAttribute(?string $name = null, mixed $value = null): self
    {
        if (!$name) {
            return $this;
        }
        if ($name === 'class') {
            $value = $this->mergeCssClasses($value);
        }
        $this->attributes[$name] = $value;

        return $this;
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
     * @param array $attributes
     * @return Element
     */
    public function setAttributes(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * @return string
     */
    private function compile(): string
    {
        $tag = [];
        $serializedAttributes = $this->serializeAttributes($this->attributes);
        if ($this->tag) {
            $tag[] = '<' . $this->tag . ($serializedAttributes ? ' ' . $serializedAttributes : '');
            if (in_array($this->tag, self::SingletonTags)) {
                $tag[] = '/>';
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

    public function getClasses(): array
    {
        return explode(' ', $this->attributes['class'] ?? '');
    }

    /**
     * @param string|array $cssClass
     * @return string
     */
    private function mergeCssClasses(string|array $cssClass): string
    {
        $newClasses = is_string($cssClass) ? explode(' ', $cssClass) : $cssClass;

        return implode(' ', array_filter(array_unique(array_merge($this->getClasses(), $newClasses))));
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
     * Create attribute string from array
     * - Adds only the attribute name if the value is null
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
                $value = htmlentities($value->serialize());
            }

            $result[] = $value === null ? $key : $key . '="' . $value . '"';;
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
}
