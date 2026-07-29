<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * A map marker's custom icon is one of three shapes: SVG/XML markup, a raw <i> HTML tag, or a
 * bare FontAwesome/RPG-Awesome class list. Each shape is sanitized separately when the marker
 * is saved (svg-sanitize, HTMLPurifier, and a strict charset respectively, see
 * MapMarkerObserver::sanitizeCustomIcon()) - this rule only needs to reject a class list
 * containing characters that couldn't survive that sanitization anyway, since those get
 * interpolated directly into a class="..." attribute on the map.
 */
class MapMarkerIcon implements ValidationRule
{
    /**
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (Str::startsWith($value, ['<svg', '<?xml', '<i '])) {
            return;
        }

        if (Str::startsWith($value, ['fa-', 'ra ']) && preg_match(FontAwesomeIcon::SAFE_CLASS_PATTERN, $value)) {
            return;
        }

        $fail(__('validation.fontawesome', ['example' => '<code>fa-solid fa-skull</code>']));
    }
}
