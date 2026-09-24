# 03 – Boolean attribute values

**Problem** `['disabled' => true, 'checked' => false]` renders `disabled="1" checked=""`.
`checked=""` means *checked* in HTML, so `false` enables the attribute.

**Plan** For PHP `bool` values only:
- `false` → attribute omitted
- `true` → treated like `null` (minimized `disabled` in HTML5, `disabled=""` in XHTML mode, same as `null` today)

Exception: `aria-*` and `data-*` keep the current output (`"1"` / `""`), since they are string attributes
and consumers (JS, a11y) may already rely on those values.
