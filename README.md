# PTag

PHP HTML abstraction, Create html elements

### Installation

`composer require fischimglas/ptag`

### Usage

- Create any HTML element with `HtmlFactory::<tagName>($attributes, $childContent)`
- Add `$element->addClass($className)` and remove `$element->removeClass($className)` css classes
- Set `$element->setAttribute($attrName,$attrValue)` and remove `$element->removeAttribute($attrName)` attributes
- Set `$element->setStyle($attrName,$attrValue)` and remove `$element->removeStyle($attrName)` attributes
- Add attributes with no value `$element->setAttribute($attrName)`
- Clone elements `$element->clone()`
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
`<div class="first-class" tabindex="1" uk-img style="background:red"><a href="#">Link</a><img src="image.png"/></div>`

### Empty container

If no html tag is defined, the element can be used as empty container. Attributes and classes to the empty container are
ignored.

```php 
use PTag\HtmlFactory;

echo HtmlFactory::empty()
    ->add('Some content')
    ->addClass('notshown');
 ```

Result:
`Some content<a href="#">Link</a>`

### Configure mode (HTML5 / XHTML)

By default, HTML5 is assumed and trailing slashes on void elements are avoided. For XHTML,
use `ElementCf::setMode(ElementCf::MODE_XHML);` to require trailing slashes.

```php 
use PTag\HtmlFactory;
use PTag\ElementCf;

ElementCf::setMode(ElementCf::MODE_XHML);

echo HtmlFactory::div()
    ->add(HtmlFactory::img(['src' => 'image.png']));
 ```

Result:
`<div><img src="image.png" /></div>`
