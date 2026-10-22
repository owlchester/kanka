<?php

namespace App\Http\Requests;

use App\Traits\ApiRequest;
use App\Traits\EntityRequestRules;
use App\Traits\ResolvesNewForeignEntities;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrganisation extends FormRequest
{
    use ApiRequest;
    use EntityRequestRules;
    use ResolvesNewForeignEntities;

    protected array $foreignEntityFields = [];

    protected bool $foreignEntityParent = true;

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
        $rules = [
            'sync_org_members' => 'nullable|boolean',
            'members' => 'nullable|array',
            'members.*' => ['nullable', 'regex:/^(m_)?[0-9]+$/'],
        ];

        return $this->entityRules($rules);
    }
}
