<?php

namespace App\Http\Requests;

use App\Facades\CampaignLocalization;
use App\Models\Entity;
use App\Models\EntityType;
use App\Rules\UniqueAttributeNames;
use App\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Stevebauman\Purify\Facades\Purify;

class StoreCustomEntity extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:191',
            'entry' => 'nullable|string',
            'type' => 'nullable|string|max:191',
            'image_uuid' => 'nullable|integer|exists:images,id',
            'parent_id' => 'nullable|integer|exists:entities,id',
            'attribute' => ['array', new UniqueAttributeNames],
        ];

        return $this->clean($rules);
    }

    protected function prepareForValidation(): void
    {
        $value = $this->input('parent_id');
        if (empty($value) || is_numeric($value)) {
            return;
        }

        // AJAX calls are validation-only pre-flight requests; replace the string with null
        // so the 'nullable' rule passes without creating an entity.
        if (request()->ajax()) {
            $this->merge(['parent_id' => null]);

            return;
        }

        $name = mb_trim(Purify::clean($value));
        if (empty($name)) {
            $this->merge(['parent_id' => null]);

            return;
        }

        // Resolve entity type from route: creation uses {entity_type}, editing uses {entity}.
        $entityType = request()->route('entity_type') ?? request()->route('entity')?->entityType;
        if (! $entityType instanceof EntityType) {
            $this->merge(['parent_id' => null]);

            return;
        }

        $campaign = CampaignLocalization::getCampaign();
        if (! auth()->user()->can('create', [$entityType, $campaign])) {
            $this->merge(['parent_id' => null]);

            return;
        }

        $entity = new Entity([
            'name' => $name,
            'campaign_id' => $campaign->id,
            'is_private' => false,
        ]);
        $entity->type_id = $entityType->id;
        $entity->save();

        $this->merge(['parent_id' => $entity->id]);
    }
}
