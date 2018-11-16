<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;
use Kalnoy\Nestedset\NodeTrait;

class AttributeTemplate extends MiscModel
{
    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'campaign_id',
        'attribute_template_id',
        'is_private',
    ];

    /**
     * Traits
     */
    use CampaignTrait, VisibleTrait, NodeTrait;

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
     * Used by the Observer to know if the tree needs rebuilding on this model.
     * @var bool
     */
    public $rebuildTree = false;

    /**
     * Parent
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attributeTemplate()
    {
        return $this->belongsTo('App\Models\AttributeTemplate', 'attribute_template_id', 'id');
    }

    /**
     * Children
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeTemplates()
    {
        return $this->hasMany('App\Models\AttributeTemplate', 'attribute_template_id', 'id');
    }

    /**
     * Parent ID field for the Node trait
     * @return string
     */
    public function getParentIdName()
    {
        return 'attribute_template_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param $value
     */
    public function setAttributeTemplateIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }


    /**
     * @param Entity $entity
     */
    public function apply(Entity $entity)
    {
        $order = 0;
        $existing = array_values($entity->attributes()->pluck('name')->toArray());
        foreach ($this->entity->attributes()->get() as $attribute) {
            // Don't re-create existing attributes.
            if (in_array($attribute->name, $existing)) {
                continue;
            }
            Attribute::create([
                'entity_id' => $entity->id,
                'name' => $attribute->name,
                'value' => $attribute->value,
                'default_order' => $attribute->default_order,
                'is_private' => $attribute->is_private,
                'type' => $attribute->type,
            ]);
            $order++;
        }

        // Loop through descendants
        foreach ($this->descendants()->with('entity')->get() as $children) {
            foreach ($children->entity->attributes()->get() as $attribute) {
                // Don't re-create existing attributes.
                if (in_array($attribute->name, $existing)) {
                    continue;
                }
                Attribute::create([
                    'entity_id' => $entity->id,
                    'name' => $attribute->name,
                    'value' => $attribute->value,
                    'default_order' => $order + $attribute->default_order,
                    'is_private' => $attribute->is_private,
                    'type' => $attribute->type,
                ]);
                $order++;
            }
        }
    }
}
