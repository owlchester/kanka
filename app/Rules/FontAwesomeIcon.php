<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class FontAwesomeIcon implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Str::startsWith($value, '<i ')) {
            $fail(__('validation.fontawesome', ['example' => '<code>fa-solid fa-skull</code>']));
        }
    }
}
