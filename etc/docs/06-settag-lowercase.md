# 06 – `setTag()` does not lowercase

**Problem** `setTag('DIV')` renders `<DIV>`, and void-tag detection fails for `setTag('IMG')`.

**Plan** Lowercase in `setTag()` like the constructor; empty string → `null`.
