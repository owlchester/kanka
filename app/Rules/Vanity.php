<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Vanity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = mb_trim($value);
        if (Str::contains($value, '/')) {
            $fail(__('campaigns/vanity.rule2', ['field' => $attribute]));
        }

        if (! preg_match('`[a-zA-Z]+`', $value)) {
            $fail(__('campaigns/vanity.rule', ['field' => $attribute]));
        }
    }
}
