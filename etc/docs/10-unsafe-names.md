# 10 – Attribute / style names are not sanitized

**Problem** Attribute names and style property names are output raw: `['a"b' => 1]` → `<div a"b="1">`,
allowing markup injection if names come from user input.

**Plan** Strip characters that are invalid in attribute names (whitespace, `" ' > / = <`, control chars)
and escape style property names. Content stays unescaped (by design, see 13).
