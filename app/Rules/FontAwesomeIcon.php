<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Translation\PotentiallyTranslatedString;

class FontAwesomeIcon implements ValidationRule
{
    /**
     * A CSS class list (FontAwesome/RPG-Awesome) only ever needs letters, digits, spaces,
     * hyphens and underscores. Anything outside that set means the value isn't a bare class
     * list - eg. it's markup, or an attribute-breakout attempt - and must be rejected, since
     * callers interpolate this value directly into a class="..." attribute.
     */
    public const SAFE_CLASS_PATTERN = '/^[a-zA-Z0-9 _-]+$/';

    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (Str::startsWith($value, '<i ') || ! preg_match(self::SAFE_CLASS_PATTERN, $value)) {
            $fail(__('validation.fontawesome', ['example' => '<code>fa-solid fa-skull</code>']));
        }
    }
}
