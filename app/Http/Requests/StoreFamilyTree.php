<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyTree extends FormRequest
{
    use ApiRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('data') !== null && $this->input('tree') === null) {
            $this->merge(['tree' => $this->input('data')]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->clean([
            'tree' => ['required', 'array'],
            'tree.nodes' => ['required', 'array'],
            'tree.nodes.*' => ['array'],
            'tree.nodes.*.id' => ['required', 'uuid', 'distinct'],
            'tree.nodes.*.entity_id' => ['nullable', 'integer'],
            'tree.nodes.*.isUnknown' => ['boolean'],
            'tree.nodes.*.role' => ['nullable', 'string', 'max:70'],
            'tree.nodes.*.colour' => ['nullable', 'string', 'max:7'],
            'tree.nodes.*.cssClass' => ['nullable', 'string', 'max:70'],
            'tree.nodes.*.visibility' => ['nullable', 'integer', 'in:1,2,5'],
            'tree.edges' => ['required', 'array'],
            'tree.edges.*' => ['array'],
            'tree.edges.*.id' => ['required', 'uuid', 'distinct'],
            'tree.edges.*.source' => ['required', 'uuid'],
            'tree.edges.*.target' => ['required', 'uuid', 'different:tree.edges.*.source'],
            'tree.edges.*.type' => ['required', 'in:partner,parent'],
            'tree.edges.*.parentage' => ['nullable', 'string', 'max:30'],
            'tree.edges.*.role' => ['nullable', 'string', 'max:70'],
            'tree.edges.*.colour' => ['nullable', 'string', 'max:7'],
            'tree.edges.*.cssClass' => ['nullable', 'string', 'max:70'],
            'tree.edges.*.visibility' => ['nullable', 'integer', 'in:1,2,5'],
        ]);
    }
}
