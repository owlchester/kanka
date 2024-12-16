<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class SocialLogin implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var ?User $user */
        $user = User::where('email', $value)->first();
        if ($user && $user->isSocialLogin()) {
                $fail(__('validation.social_login', ['provider' => Str::upper($user->provider)]));
        }
    }
}
