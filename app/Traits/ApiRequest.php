<?php

namespace App\Traits;

use App\Facades\Domain;

trait ApiRequest
{
    /**
     * On API PUT requests, don't have all the fields as required
     */
    public function clean(array $rules, array $except = []): array
    {
        $isApi = Domain::isApi();
        if (! $isApi || ! (request()->isMethod('put') || request()->isMethod('patch'))) {
            return $rules;
        }

        foreach ($rules as $field => $rule) {
            if (! is_string($rule)) {
                continue;
            }

            // Remove any required| rule, and remove any alone |
            $rules[$field] = mb_trim(
                str_replace('required|', '', $rule),
                '|'
            );
        }

        if ($except) {
            // Do something with this?
        }

        return $rules;
    }
}
