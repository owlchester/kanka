<?php


namespace App\Services\Entity;


use App\Facades\Mentions;
use App\Models\Ability;
use App\Models\Attribute;
use App\Models\Entity;
use App\Models\EntityAbility;
use Illuminate\Support\Facades\Auth;

class AbilityService
{
    /** @var Entity */
    protected $entity;

    /** @var array All the abilities of this entity, nicely prepared */
    protected $abilities = [
        'parents' => [],
        'abilities' => [],
        'meta' => []
    ];

    /**
     * @param Entity $entity
     * @return $this
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * @return array
     */
    public function abilities(): array
    {
        /** @var EntityAbility $ability */
        foreach ($this->entity->abilities()->with(['ability', 'ability.entity', 'ability.entity.attributes', 'ability.ability', 'ability.ability.entity'])->get() as $ability) {
            // Can't read the ability? skip
            if (empty($ability->ability)) {
                continue;
            }
            // If this ability has a parent ability, save it there
            $this->add($ability);
        }

        // Meta
        $this->abilities['meta'] = [
            'add_url' => route('entities.entity_abilities.create', $this->entity),
            'user_id' => Auth::check() ? Auth::user()->id : 0,
            'is_admin' => Auth::check() && Auth::user()->isAdmin(),
        ];

        return $this->abilities;
    }

    /**
     * @param Ability $ability
     */
    protected function add(EntityAbility $entityAbility): void
    {
        /** @var Ability $parent */
        $ability = $entityAbility->ability;
        $parent = $ability->ability;
        if (!empty($parent)) {
            if (!isset($this->abilities['parents'][$parent->id])) {
                $this->abilities['parents'][$parent->id] = [
                    'id' => $parent->id,
                    'name' => $parent->name,
                    'type' => $parent->type,
                    'image' => $parent->getImageUrl(),
                    'has_image' => !empty($parent->image),
                    'entry' => $parent->entry(),
                    'parent' => true,
                    'abilities' => [],
                ];
            }

            $this->abilities['parents'][$parent->id]['abilities'][] = $this->format($entityAbility);
        } else {
            $this->abilities['abilities'][$ability->id] = $this->format($entityAbility);
        }
    }

    /**
     * @param Ability $ability
     * @return array
     */
    protected function format(EntityAbility $entityAbility): array
    {
        return [
            'ability_id' => $entityAbility->ability_id,
            'name' => $entityAbility->ability->name,
            'entry' => $entityAbility->ability->entry(),
            'type' => $entityAbility->ability->type,
            'visibility' => $entityAbility->visibility,
            'created_by' => $entityAbility->created_by,
            'attributes' => $this->attributes($entityAbility->ability->entity),
            'actions' => [
                'edit' => route('entities.entity_abilities.update', [$this->entity, $entityAbility]),
                'delete' => route('entities.entity_abilities.destroy', [$this->entity, $entityAbility]),
            ],
        ];
    }

    protected function attributes(Entity $entity): array
    {
        $attributes = [];
        /** @var Attribute $attr */
        foreach ($entity->attributes->sortBy('default_order') as $attr) {
            $attributes[] = [
                'id' => $attr->id,
                'name' => $attr->name,
                'value' => $attr->value,
            ];
        }
        return $attributes;
    }
}
