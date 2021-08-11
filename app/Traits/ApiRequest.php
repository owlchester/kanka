<?php


namespace App\Traits;


trait ApiRequest
{
    /**
     * On API PUT requests, don't have all the fields as required
     * @param array $rules
     * @param array $except
     * @return array
     */
    public function clean(array $rules, array $except = []): array
    {
        if (!request()->is('api/*') || !request()->isMethod('put')) {
            return $rules;
        }

        foreach ($rules as $field => $rule) {
            if (!is_string($rule)) {
                continue;
            }

            // Remove any required| rule, and remove any alone |
            $rules[$field] = trim(
                str_replace('required|', null, $rule),
                '|'
            );
        }

        return $rules;
    }
}
