# 04 – `clone()` is shallow

**Problem** Child elements are shared between original and clone; modifying a child changes both.

**Plan** Add `__clone()` that recursively clones `Element` instances in content (incl. nested arrays).
`clone()` signature unchanged.
