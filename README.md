# PTag

Create html elements

### Usage

- Create any HTML element with `HtmlFactory::<tagName>($attributes, $childContent)`
- Add `$element->addClass($className)` and remove `$element->removeClass($className)` css classes
- Set `$element->setAttribute($attrName,$attrValue)` and remove `$element->removeAttribute($attrName)` attributes
- Add attributes with no value `$element->setAttribute($attrName)`
- Clone elements `$element->clone()`
- Chain modifications `$element->clone()->add($anyContent)->addClass('test')`

### Example

```php 
use src\HtmlFactory;

$html = HtmlFactory::div()
    ->addClass('first-class')
    ->setAttribute('tabindex', 1)
    ->setAttribute('uk-img')
    ->add(HtmlFactory::a(['href' => '#'], 'Link'))
    ->add(HtmlFactory::img(['src' => 'image.png']));

echo $html;

<div class="first-class" tabindex="1" uk-img><a href="#">Link</a><img src="image.png"/></div>
 ```

### Empty container

If no html tag is defined, the element can be used as empty container. Attributes and classes to the empty container are
ignored.

```php 
use src\Element;

$html = new Element();
$html->add('Some content')
    ->addClass('notshown');

Some content<a href="#">Link</a>
 ```

