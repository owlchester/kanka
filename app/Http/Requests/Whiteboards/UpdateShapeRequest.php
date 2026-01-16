<?php

namespace App\Http\Requests\Whiteboards;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShapeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->whiteboard->entity);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'x' => '',
            'y' => '',
            'scale_x' => '',
            'scale_y' => '',
            'rotation' => '',
            'width' => '',
            'height' => '',
            'is_locked' => 'boolean',
            'z_index' => 'integer',
        ];
    }
}
