# PTag

PHP HTML abstraction, Create html elements

### Installation

`composer require fischimglas/ptag`

### Usage

- Create any HTML element with `HtmlFactory::<tagName>($attributes, $childContent)`
- Add `$element->addClass($className)` and remove `$element->removeClass($className)` css classes
- Set `$element->setAttribute($attrName,$attrValue)` and remove `$element->removeAttribute($attrName)` attributes
- Set `$element->setStyle($styleName,$styleValue)` and remove `$element->removeStyle($styleName)` inline styles
  (combined with a `style` attribute, if one is set)
- Array attribute values: lists are joined with spaces (`['rel' => ['noopener', 'noreferrer']]`),
  associative arrays become `key:value;…`
- Add attributes with no value `$element->setAttribute($attrName)`
- Boolean values: `true` renders the attribute without value (`disabled="disabled"` in XHTML mode), `false` omits it.
  `aria-*` and `data-*` render `"true"` / `"false"`
- Clone elements `$element->clone()` (deep copy, child elements are cloned too)
- Add escaped text `$element->addText($userInput)` or `HtmlFactory::text($userInput)`
- Chain modifications `$element->clone()->add($anyContent)->addClass('test')`

### Basic example

```php 
use PTag\HtmlFactory;

echo HtmlFactory::div()
    ->addClass('first-class')
    ->setAttribute('tabindex', 1)
    ->setAttribute('uk-img')
    ->setStyle('background','red')
    ->add(HtmlFactory::a(['href' => '#'], 'Link'))
    ->add(HtmlFactory::img(['src' => 'image.png']));
 ```

Result:
`<div class="first-class" tabindex="1" uk-img style="background:red"><a href="#">Link</a><img src="image.png"></div>`

### Empty container

If no html tag is defined, the element can be used as empty container. Attributes and classes to the empty container are
ignored.

```php 
use PTag\HtmlFactory;

echo HtmlFactory::empty()
    ->add('Some content')
    ->add(HtmlFactory::a(['href' => '#'], 'Link'))
    ->addClass('notshown');
 ```

Result:
`Some content<a href="#">Link</a>`

### Configure mode (HTML5 / XHTML)

By default, HTML5 is assumed and trailing slashes on void elements are avoided. For XHTML,
use `ElementCf::setMode(ElementCf::MODE_XHTML);` to require trailing slashes and disable attribute minimization.
(`ElementCf::MODE_XHML` still works but is deprecated.)

```php 
use PTag\HtmlFactory;
use PTag\ElementCf;

ElementCf::setMode(ElementCf::MODE_XHTML);

echo HtmlFactory::div()
    ->add(HtmlFactory::img(['src' => 'image.png']));
 ```

Result:
`<div><img src="image.png" /></div>`

### Reading and editing elements

```php
use PTag\HtmlFactory;

$el = HtmlFactory::div(['id' => 'box', 'class' => 'a b', 'hidden'], 'content');

$el->getTag();                 // 'div'
$el->hasAttribute('hidden');   // true (also for attributes without value)
$el->getAttribute('id');       // 'box'
$el->getAttributes();          // ['id' => 'box', 'class' => 'a b', 'hidden' => null]
$el->hasClass('a b');          // true, all given classes are set
$el->toggleClass('b c');       // class="a c"
$el->toggleClass('a', false);  // always removes (true always adds)

$el->setStyles(['margin' => 0, 'color' => 'red']);
$el->getStyle('margin');       // 0
$el->getStyles();              // ['margin' => 0, 'color' => 'red']

$el->prepend('first ');        // add at the beginning
$el->getChildren();            // ['first ', 'content']
$el->clearChildren();          // remove all children
```

### Documents and comments

```php
echo HtmlFactory::empty([
    HtmlFactory::doctype(),
    HtmlFactory::comment('generated'),
    HtmlFactory::html(['lang' => 'en'], HtmlFactory::body([], 'Hello')),
]);
```

Result:
`<!DOCTYPE html><!-- generated --><html lang="en"><body>Hello</body></html>`

### CSS classes

`addClass(...)` adds to the existing classes, `setAttribute('class', ...)` replaces them. Duplicates are removed
in both cases.

```php
echo HtmlFactory::div(['class' => 'a'])->addClass('b');           // <div class="a b"></div>
echo HtmlFactory::div(['class' => 'a'])->setAttribute('class', 'b'); // <div class="b"></div>
```

### Escaping

- Attribute values and style values are escaped with `htmlentities()`.
- Attribute names and style property names are sanitized (invalid characters are removed).
- **Child content passed to the factory or `add()` is not escaped.** Strings are output as raw HTML.
  Use `HtmlFactory::text()` or `addText()` for user input:

```php
echo HtmlFactory::p([], HtmlFactory::text('<b>Tom & Jerry</b>')); // <p>&lt;b&gt;Tom &amp; Jerry&lt;/b&gt;</p>
echo HtmlFactory::p()->addText($userInput)->add('<br>');         // escaped text, raw <br>
```
