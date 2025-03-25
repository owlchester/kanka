<?php

namespace App\Http\Resources;

trait ApiExclusion
{
    public function excludeForApi(array $fields, array $rules): array
    {
        foreach ($fields as $field) {
            if (! request()->has($field)) {
                unset($rules[$field]);
            }
        }

        return $rules;
    }
}
