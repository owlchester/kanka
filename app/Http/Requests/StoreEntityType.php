<?php

namespace App\Http\Requests;

use App\Facades\Limit;
use App\Services\CategoryStatusService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEntityType extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->boolean('statuses_present') && ! $this->has('statuses')) {
            $this->merge(['statuses' => []]);
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'singular' => ['required', 'string', 'max:45'],
            'plural' => ['required', 'string', 'max:45'],
            'icon' => ['required', 'string', 'max:100'],
            'roles' => 'array',
            'roles.*' => 'integer|exists:campaign_roles,id',
            'default_entity_image' => 'mimes:jpeg,png,jpg,gif,webp|max:' . Limit::upload(),
            'statuses' => ['sometimes', 'array', 'max:10'],
            'statuses.*' => ['array:id,label,icon,is_default'],
            'statuses.*.id' => ['nullable', 'integer', 'distinct'],
            'statuses.*.label' => CategoryStatusService::definitionRules()['label'],
            'statuses.*.icon' => CategoryStatusService::definitionRules()['icon'],
            'statuses.*.is_default' => ['sometimes', 'boolean'],
        ];
    }
}
