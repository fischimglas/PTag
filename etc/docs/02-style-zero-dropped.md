# 02 – Style value `0` is dropped

**Problem** `setStyle('opacity', 0)` renders nothing: `array_filter()` in `serializeStyle()` removes falsy values.

**Plan** Filter only `null`, `''` and `false`; keep `0` / `'0'`.
