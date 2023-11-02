<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Vanity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = trim($value);
        if (strpos($value, '/')) {
            $fail(__('campaigns/vanity.rule2', ['field' => $attribute]));
        }

        if (!preg_match('`[a-zA-Z]+`', $value)) {
            $fail(__('campaigns/vanity.rule', ['field' => $attribute]));
        }
    }
}
