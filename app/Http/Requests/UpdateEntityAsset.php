<?php

namespace App\Http\Requests;

use App\Enums\EntityAssetType;
use App\Facades\Limit;
use App\Rules\EntityFile;
use App\Rules\FontAwesomeIcon;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateEntityAsset extends FormRequest
{
    use ApiRequest;

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
     * @return array<string, array<int, mixed>|string>
     */
    public function rules(): array
    {
        return $this->clean([
            'type_id' => ['required', new Enum(EntityAssetType::class)],
            'name' => 'required_unless:type_id,' . EntityAssetType::file->value . '|max:45',
            'visibility_id' => 'nullable|integer|exists:visibilities,id',
            'file' => [
                'nullable',
                'file',
                'max:' . Limit::upload(),
                new EntityFile,
            ],
            'metadata.url' => 'required_if:type_id,' . EntityAssetType::link->value . '|string|url',
            'metadata.icon' => ['max:45', new FontAwesomeIcon],
        ]);
    }
}
