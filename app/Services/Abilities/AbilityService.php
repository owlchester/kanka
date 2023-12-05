<?php

namespace App\Services\Abilities;

use App\Facades\Avatar;
use App\Facades\Mentions;
use App\Models\Attribute;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;

class AbilityService extends BaseAbilityService
{
    use CampaignAware;
    use EntityAware;

    /** @var array All the abilities of this entity, nicely prepared */
    protected array $abilities = [
        'parents' => [],
        'abilities' => [],
        'meta' => []
    ];

    /** @var array A list of abilities that have already been loaded */
    protected array $abilityIds = [];

    /**
     */
    public function abilities(): array
    {
        $abilities = $this->entity->abilities()
            ->select('entity_abilities.*')
            ->with(['ability',
                // entity
                'ability.entity', 'ability.entity.image', 'ability.entity.attributes',
                // parent
                'ability.ability', 'ability.ability.entity', 'ability.ability.entity.tags', 'ability.ability.entity.image'
            ])
            ->join('abilities as a', 'a.id', 'entity_abilities.ability_id')
            ->defaultOrder()
            ->get();
        /** @var EntityAbility $ability */
        foreach ($abilities as $ability) {
            // Can't read the ability? skip
            if (empty($ability->ability) || empty($ability->ability->entity)) {
                continue;
            }
            // If this ability has a parent ability, save it there
            $this->add($ability);
        }

        // Reorder parents
        usort($this->abilities['parents'], function ($a, $b) {
            return strcmp(mb_strtoupper($a['name']), mb_strtoupper($b['name']));
        });

        // Meta
        $this->abilities['meta'] = [
            'add_url' => route('entities.entity_abilities.create', [$this->campaign, $this->entity]),
            'user_id' => auth()->check() ? auth()->user()->id : 0,
            'is_admin' => auth()->check() && auth()->user()->isAdmin(),
        ];
        return $this->abilities;
    }



    /**
     */
    protected function add(EntityAbility $entityAbility): void
    {
        $ability = $entityAbility->ability;
        $parent = $ability->ability;

        if (empty($parent)) {
            if (in_array($ability->id, $this->abilityIds)) {
                return;
            }
            // Abilities need to be added to the array in the order they get loaded, but we also want to avoid abilities
            // appearing multiple times somehow.
            $this->abilities['abilities'][] = $this->format($entityAbility);
            $this->abilityIds[] = $ability->id;
            return;
        }

        if (!isset($this->abilities['parents'][$parent->id])) {
            $this->abilities['parents'][$parent->id] = [
                'id' => $parent->id,
                'name' => $parent->name,
                'type' => $parent->type,
                'image' => Avatar::entity($parent->entity)->size(120)->thumbnail(),
                'has_image' => !empty($parent->entity->image_path) || !empty($parent->entity->image),
                'entry' => $parent->entry(),
                'parent' => true,
                'abilities' => [],
                'url' => $parent->getLink(),
            ];
        }

        // Add to their parent's abilities
        $this->abilities['parents'][$parent->id]['abilities'][] = $this->format($entityAbility);
    }

    /**
     */
    protected function format(EntityAbility $entityAbility): array
    {
        $classes = [];
        foreach ($entityAbility->ability->entity->tagsWithEntity() as $tag) {
            $classes[] = ' kanka-tag-' . $tag->id;
            $classes[] = ' kanka-tag-' . $tag->slug;

            if ($tag->tag_id) {
                $classes[] = ' kanka-tag-' . $tag->tag_id;
            }
        }
        //implode(' ', $classes);

        $data = [
            'ability_id' => $entityAbility->ability_id,
            'name' => $entityAbility->ability->name,
            'entry' => $this->parseEntry($entityAbility->ability),
            'type' => $entityAbility->ability->type,
            'charges' => $this->parseCharges($entityAbility->ability),
            'used_charges' => $entityAbility->charges,
            'class' => $classes,
            'note' => nl2br((string) $this->mapAttributes(
                Mentions::mapAny($entityAbility, 'note'),
                false
            )),
            'visibility_id' => $entityAbility->visibility_id,
            'created_by' => $entityAbility->created_by,
            'attributes' => $this->attributes($entityAbility->ability->entity),
            'images' => [
                'has' => !empty($entityAbility->ability->entity->image_path) || $entityAbility->ability->entity->image,
                'thumb' => Avatar::entity($entityAbility->ability->entity)->size(120)->thumbnail(),
                'url' => Avatar::entity($entityAbility->ability->entity)->original(),
            ],
            'actions' => [
                'edit' => route('entities.entity_abilities.edit', [$this->campaign, $this->entity, $entityAbility]),
                'update' => route('entities.entity_abilities.update', [$this->campaign, $this->entity, $entityAbility]),
                'delete' => route('entities.entity_abilities.destroy', [$this->campaign, $this->entity, $entityAbility]),
                'view' => route('entities.show', [$this->campaign, $entityAbility->ability->entity]),
            ],
            'entity' => [
                'id' => $entityAbility->ability->entity->id,
                'tooltip' => route('entities.tooltip', [$this->campaign, $entityAbility->ability->entity->id])
            ]
        ];

        if (!empty($entityAbility->ability->charges)) {
            $data['actions']['use'] = route('entities.entity_abilities.use', [$this->campaign, $this->entity, $entityAbility]);
        }

        return $data;
    }

    /**
     */
    protected function attributes(Entity $entity): array
    {
        $attributes = [];
        /** @var Attribute $attr */
        foreach ($entity->attributes->sortBy('default_order') as $attr) {
            $attributes[] = [
                'id' => $attr->id,
                'name' => $attr->name,
                'value' => Mentions::mapAttribute($attr),
                'type' => $attr->type,
            ];
        }
        return $attributes;
    }
}
