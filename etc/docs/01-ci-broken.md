# 01 – CI broken

**Problem**
- Workflow runs `composer run-script test`, composer.json only defines `tests`.
- `composer validate --strict` fails: lock file out of date, `version` field present.

**Plan**
- Add a `test` script (keep `tests` as alias so existing usage keeps working).
- Remove the `version` field (Packagist uses git tags).
- Refresh the lock file hash (`composer update --lock`).
