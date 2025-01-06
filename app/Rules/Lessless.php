<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Lessless implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Str::contains(mb_strtolower($value), '<')) {
            $fail(__('validation.forbidden_letter', ['attribute' => $attribute, 'letter' => '&lt;']));
        }
    }
}
