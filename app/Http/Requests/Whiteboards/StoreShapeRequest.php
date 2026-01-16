<?php

namespace App\Http\Requests\Whiteboards;

use Illuminate\Foundation\Http\FormRequest;

class StoreShapeRequest extends FormRequest
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
            'type' => 'required|string',
            'shape' => 'required',
            'x' => 'required|integer',
            'y' => 'required|integer',
            'scale_x' => 'required|integer',
            'scale_y' => 'required|integer',
            'rotation' => 'integer',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'is_locked' => 'boolean',
            'z_index' => 'integer',
        ];
    }
}
