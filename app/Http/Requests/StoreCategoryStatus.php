<?php

namespace App\Http\Requests;

use App\Services\CategoryStatusService;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryStatus extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('setting', $this->route('campaign')) ?? false;
    }

    public function rules(): array
    {
        return CategoryStatusService::definitionRules();
    }
}
