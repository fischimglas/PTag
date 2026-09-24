# 08 – Numeric CSS class names dropped

**Problem** `['class' => ['a', 5]]` renders `class="a"`.

**Plan** Accept ints/floats in class arrays by casting to string in `flattenNestedArray()`.
