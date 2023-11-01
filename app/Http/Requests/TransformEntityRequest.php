<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransformEntityRequest extends FormRequest
{
    protected string $entities;

    public function __construct()
    {
        parent::__construct();

        $entities = [];
        foreach (config('entities.classes') as $entity => $class) {
            $entities[] = $entity;
        }

        $this->entities = implode(',', $entities);
    }

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
            'target' => 'required|in:' . $this->entities,
        ];
    }
}
