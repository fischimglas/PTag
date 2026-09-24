# 07 – Attributes of tagless elements are discarded

**Problem** `new Element(null, ['id' => 'x'])` drops attributes, so a later `setTag('div')` renders `<div></div>`.

**Plan** Always store attributes. Tagless elements still don't render them (README behaviour kept).
