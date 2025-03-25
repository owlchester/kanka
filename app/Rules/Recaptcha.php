<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = [
            'secret' => config('auth.recaptcha.secret'),
            'response' => $value,
        ];
        $res = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', $data);
        // Log::info('Recaptcha request', $data);
        if (! $res->json('success')) {
            // Log::info('Recaptcha request', $res->json());
            $fail(__('Invalid request, please try again.'));
        }
    }
}
