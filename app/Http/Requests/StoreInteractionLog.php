<?php

namespace App\Http\Requests;

use App\Enums\InteractionLogVisibility;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInteractionLog extends FormRequest
{
    use ApiRequest;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->clean([
            'entity_id' => $this->isMethod('post')
                ? ['required', 'integer', 'exists:entities,id']
                : ['sometimes', 'integer', 'exists:entities,id'],
            'note' => $this->isMethod('post')
                ? ['required', 'string']
                : ['sometimes', 'string'],
            'visibility' => ['sometimes', 'nullable', Rule::enum(InteractionLogVisibility::class)],
        ]);
    }
}
