# 05 – `setAttribute('class', …)` merges

**Problem** Setting `class` via `setAttribute` appends instead of replacing.

**Decision: won't fix.** Libraries may rely on the merge behaviour (constructor attributes + later
`setAttribute('class')`). Changing it would break the API contract. Documented in README instead;
use `removeAttribute('class')` first to replace.
