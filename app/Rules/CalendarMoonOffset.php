<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CalendarMoonOffset implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Max value
        $lengths = request()->get('month_length');
        if (! is_array($lengths) || count($lengths) === 0) {
            $fail(__('calendars.validators.moon_offset'));
        }
        $max = $lengths[0];
        $min = 0 - $max;

        foreach ($value as $offset) {
            if ($offset > $max || $offset < $min) {
                $fail(__('calendars.validators.moon_offset'));
            }
        }
    }
}
