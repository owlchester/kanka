<?php


namespace App\Services\Entity;


use App\Facades\Mentions;
use App\Models\Ability;
use App\Models\Attribute;
use App\Models\Entity;
use App\Models\EntityAbility;

class AbilityService
{
    /** @var Entity */
    protected $entity;

    /** @var array All the abilities of this entity, nicely prepared */
    protected $abilities = [
        'parents' => [],
        'abilities' => [],
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
        foreach ($this->entity->abilities()->with(['ability', 'ability.entity', 'ability.ability', 'ability.ability.entity'])->get() as $ability) {
            // If this ability has a parent ability, save it there
            $this->add($ability);
        }

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
                    'parent' => true,
                    'abilities' => []
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
            'name' => $entityAbility->ability->name,
            'entry' => Mentions::map($entityAbility->ability),
            'type' => $entityAbility->ability->type,
            'visibility' => $entityAbility->visibility,
            'attributes' => $this->attributes($entityAbility->ability->entity)
        ];
    }

    protected function attributes(Entity $entity): array
    {
        $attributes = [];
        /** @var Attribute $attr */
        foreach ($entity->attributes()->ordered()->get() as $attr) {
            $attributes[] = [
                'id' => $attr->id,
                'name' => $attr->name,
                'value' => $attr->value,
            ];
        }
        return $attributes;
    }
}
