# PTag – Issue index

Constraint for every fix: **the public API must remain the same** (class names, method names,
signatures, constants). Only additive changes and fixes of clearly broken output are allowed.

| # | Issue | Status |
|---|-------|--------|
| 01 | [CI: composer script name / validate fails](01-ci-broken.md) | fixed |
| 02 | [Style value `0` is dropped](02-style-zero-dropped.md) | fixed |
| 03 | [Boolean attribute values render wrong](03-boolean-attributes.md) | fixed |
| 04 | [`clone()` is shallow](04-shallow-clone.md) | fixed |
| 05 | [`setAttribute('class', …)` merges instead of replacing](05-class-attribute-merge.md) | open |
| 06 | [`setTag()` does not lowercase](06-settag-lowercase.md) | fixed |
| 07 | [Attributes of tagless elements are discarded](07-tagless-attributes.md) | fixed |
| 08 | [Numeric CSS class names are dropped](08-numeric-classes.md) | open |
| 09 | [Array style values produce invalid CSS](09-array-style-values.md) | open |
| 10 | [Attribute / style names are not sanitized](10-unsafe-names.md) | open |
| 11 | [Missing tags in `HtmlFactory`](11-missing-factory-tags.md) | open |
| 12 | [`MODE_XHML` typo](12-mode-xhml-typo.md) | open |
| 13 | [README errors and missing escaping note](13-readme.md) | open |
| 14 | [Test coverage gaps](14-tests.md) | open |
| 15 | [Outdated CI action](15-ci-cache-action.md) | open |
