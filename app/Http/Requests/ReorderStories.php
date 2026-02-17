<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReorderStories extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'posts' => [
                '*' => [
                    'id' => 'integer|exists:posts,id',
                    'visibility_id' => 'integer|exists:visibilities,id',
                ],
            ],
        ];
    }
}
