<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;

class AttributeTemplate extends MiscModel
{
    //
    protected $fillable = [
        'name',
        'slug',
        'campaign_id',
        'is_private',
    ];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'attribute_template';

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name'];

    /**
     * @param Entity $entity
     */
    public function apply(Entity $entity)
    {
        $existing = array_values($entity->attributes()->pluck('name')->toArray());
        foreach ($this->entity->attributes()->get() as $attribute) {
            // Don't re-create existing attributes.
            if (in_array($attribute->name, $existing)) {
                continue;
            }
            $new  = Attribute::create([
                'entity_id' => $entity->id,
                'name' => $attribute->name,
                'value' => $attribute->value,
                'default_order' => $attribute->default_order,
                'is_private' => $attribute->is_private,
            ]);
        }
    }
}
