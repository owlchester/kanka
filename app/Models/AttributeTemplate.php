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
        foreach ($this->entity->attributes()->get() as $attribute) {
            $new  = Attribute::create([
                'entity_id' => $entity->id,
                'name' => $attribute->name,
                'value' => $attribute->value,
                'is_private' => $attribute->is_private,
            ]);
        }
    }
}
