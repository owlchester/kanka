# Translate Missing Strings

Translate missing translations for the given locale.

Usage: /translate [locale_code] [locale_name]
Example: /translate fr French

## Steps

1. Run `php artisan translations:missing $ARGUMENTS` and capture the output
2. For each missing key/string:
    - Translate the English string to the target language naturally (not literally)
    - Preserve `:variable` placeholders, `<html>` tags, and pluralization syntax exactly
    - Match tone/formality of existing translations (check a few rows in ltm_translations first)
3. Insert each translation into `ltm_translations`
4. Confirm count of translations added

## Rules
- Never guess at technical terms — keep English if unsure
- Kanka-specific terms (Whiteboard) stay in English unless an equivalent already exists in the DB for that locale
```

Then invoke as:
```
/translate fr French
/translate de German
/translate es Spanish

## Locale rules

Apply these rules based on the target locale:

**fr**
- Use Swiss French spelling and idioms
- No space before `:` `!` `?` `;` (Swiss convention, unlike standard French)
- Prefer Swiss vocabulary where it differs (e.g. "septante" vs "soixante-dix" if numbers appear)

**es**
- Default to neutral Latin American Spanish unless specified otherwise
