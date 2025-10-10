<?php

namespace App\Http\Requests;

use App\Enums\EntityAssetType;
use App\Facades\Limit;
use App\Models\EntityAsset;
use App\Rules\EntityFile;
use App\Rules\FontAwesomeIcon;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreEntityAssets extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->clean([
            'name' => 'required_unless:type_id,' . EntityAssetType::FILE->value . '|max:45',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
            'files' => ['required_if:type_id,' . EntityAssetType::FILE->value],
            'files.*' => [
                'file',
                'max:' . Limit::upload(),
                new EntityFile,
            ],
            'metadata.url' => 'required_if:type_id,' . EntityAssetType::LINK->value . '|string|url',
            'metadata.icon' => ['max:45', new FontAwesomeIcon],
        ]);
    }
}
