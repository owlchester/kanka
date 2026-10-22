<?php

namespace App\Traits;

use App\Models\Entity;
use App\Models\Location;
use App\Models\Tag;
use App\Rules\EntityField;
use App\Rules\Nested;
use App\Rules\UniqueAttributeNames;
use Illuminate\Validation\Rule;

trait EntityRequestRules
{
    public function quickCreatorRules(): array
    {
        return $this->rules();
    }

    protected function entityRules(array $rules): array
    {
        $parentRules = ['nullable', 'integer', 'exists:entities,id'];
        $entity = $this->route('entity') ?? request()->route('entity');
        if ($entity instanceof Entity) {
            $parentRules[] = new Nested($entity);
        }

        $rules += [
            'name' => 'required|string|max:191',
            'entry' => 'nullable|string',
            'type' => 'nullable|string|max:191',
            'attribute' => ['array', new UniqueAttributeNames],
            'tooltip' => 'nullable|string',
            'image_uuid' => 'nullable|exists:images,id',
            'header_uuid' => 'nullable|exists:images,id',
            'entity_image_uuid' => 'nullable|exists:images,id',
            'entity_header_uuid' => 'nullable|exists:images,id',
            'status_id' => 'nullable|exists:category_statuses,id',
            'parent_id' => $parentRules,
            'locations' => ['nullable', 'array', new EntityField(config('entities.ids.location'), Location::class)],
            'tags' => ['nullable', 'array', new EntityField(config('entities.ids.tag'), Tag::class)],
            'save-tags' => 'nullable|boolean',
            'save_locations' => 'nullable|boolean',
            'remove-image' => 'nullable|boolean',
            'remove-header_image' => 'nullable|boolean',
            'copy_permissions' => 'nullable|boolean',
            'is_attributes_private' => 'nullable|boolean',
            'permissions_too_many' => 'nullable|boolean',
            'role' => 'nullable|array',
            'role.*' => 'array',
            'role.*.*' => 'in:allow,deny,inherit',
            'user' => 'nullable|array',
            'user.*' => 'array',
            'user.*.*' => 'in:allow,deny,inherit',
        ];

        $rules['is_private'] = [
            Rule::excludeIf(fn () => ! $this->user()?->can('admin', $this->route('campaign'))),
            'nullable',
            'boolean',
        ];

        return $this->clean($rules);
    }
}
