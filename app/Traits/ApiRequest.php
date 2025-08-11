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
        $isApi = Domain::isApi() || app()->environment('testing');
        if (! $isApi || ! (request()->isMethod('put') || request()->isMethod('patch'))) {
            return $rules;
        }

        foreach ($rules as $field => $rule) {
            if (! is_string($rule)) {
                if (($key = array_search('required', $rule, true)) !== false) {
                    unset($rule[$key]);
                    $rules[$field] = $rule;

                }
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
