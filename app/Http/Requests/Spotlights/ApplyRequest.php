<?php

namespace App\Http\Requests\Spotlights;

use Illuminate\Foundation\Http\FormRequest;

class ApplyRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isApply = $this->string('action')->toString() === 'apply';
        $requiredOrNullable = $isApply ? 'required|string|min:15' : 'nullable|string';


        return [
            'action' => 'nullable|in:save,apply',

            'time' => $requiredOrNullable,
            'world' => $requiredOrNullable,
            'proud' => $requiredOrNullable,
            'inspiration' => $requiredOrNullable,
            'stories' => $requiredOrNullable,
            'kanka' => 'nullable|string',
        ];
    }
}
