# 09 – Array style values produce invalid CSS

**Problem** `setStyle('margin', [0, 'auto'])` renders `margin:0:0;1:auto`; `setStyle('x', ['a' => 1])` renders `x:a:1`.

**Plan** Join array values with a space: `margin:0 auto`.
