<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePlayerSession extends FormRequest
{
    use ApiRequest;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->clean([
            'entity_claim_id' => $this->isMethod('post')
                ? ['required', 'integer', 'exists:entity_claims,id']
                : ['prohibited'],
            'name' => $this->isMethod('post')
                ? ['nullable', 'string', 'max:191']
                : ['sometimes', 'nullable', 'string', 'max:191'],
            'started_at' => $this->isMethod('post')
                ? ['nullable', 'date']
                : ['sometimes', 'nullable', 'date'],
            'ended_at' => $this->isMethod('post')
                ? ['nullable', 'date', 'after_or_equal:started_at']
                : ['sometimes', 'nullable', 'date'],
            'summary' => ['sometimes', 'nullable', 'string'],
        ]);
    }
}
