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
            'group_id' => 'nullable|integer|exists:whiteboard_shapes,id',
            'x' => 'numeric',
            'y' => 'numeric',
            'scale_x' => 'numeric',
            'scale_y' => 'numeric',
            'rotation' => 'numeric',
            'width' => 'numeric',
            'height' => 'numeric',
            'is_locked' => 'boolean',
            'z_index' => 'integer',
        ];
    }
}
