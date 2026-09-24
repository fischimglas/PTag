# Changelog

## 1.1.0

The public API is unchanged (only additions), but the generated HTML differs in several cases listed below.

### Added
- `Element::addText()` and `HtmlFactory::text()` for escaped text content
- `HtmlFactory` tags: `b`, `base`, `br`, `caption`, `datalist`, `dd`, `fieldset`, `hr`, `kbd`, `output`, `q`,
  `rp`, `rt`, `ruby`, `s`, `samp`, `script`, `tfoot`, `wbr`
- `ElementCf::MODE_XHTML` (same value as `MODE_XHML`, which is now deprecated)
- List entries in attribute arrays are attributes without value: `['required', 'type' => 'text']`

### Changed (output)
- `setAttribute('class', ...)` replaces the classes; `addClass()` still merges
- Boolean attributes: `false` omits the attribute, `true` renders it without value
  (`name="name"` in XHTML mode); `aria-*` / `data-*` render `"true"` / `"false"`
- A `style` attribute and `setStyle()` values are combined into one `style` attribute, rendered last
- Array attribute values: lists are joined with spaces (`rel="noopener noreferrer"`),
  associative arrays render `key:value;...`; array style values are joined with spaces (`margin:0 auto`)
- Attribute and style values are escaped with `htmlspecialchars()` instead of `htmlentities()`:
  non-ASCII characters are no longer converted to entities
- Attribute names and style property names are sanitized (invalid characters removed)
- `true` / `false` as child content render nothing
- `command` and `keygen` are no longer void elements
- `ElementCf::setMode()` with an unknown mode throws `InvalidArgumentException` and keeps the current mode
- Invalid tag names (e.g. containing spaces, quotes or `<>`) throw `InvalidArgumentException`
  in the constructor, `HtmlFactory::element()` and `setTag()`; custom elements like `my-widget` are allowed

### Fixed
- `clone()` is a deep copy, child elements are no longer shared
- Style values `0` / `'0'` were dropped
- `setTag()` did not lowercase the tag name
- Attributes passed to a tagless element were lost when `setTag()` was called later
- Numeric class names were dropped; a class named `"0"` was dropped
- `class` values `true`, `false` or objects threw a `TypeError`; `Stringable` objects are used as class names
- `removeAttribute()` did not remove attributes without value
- `getClasses()` returned `['']` when there are no classes, now `[]`
- Child objects with `__toString()` rendered as `{}` (JSON), now as text
- Nested arrays in attribute values rendered `Array`

### Development
- Codeception 5, PHPStan (level max), CI on PHP 8.1 – 8.4
- `composer test` (and `composer tests`), `composer analyse`
