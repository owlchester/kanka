<?php


namespace App\Services\Entity;


use App\Facades\Mentions;
use App\Models\Ability;
use App\Models\Attribute;
use App\Models\Entity;
use App\Models\EntityAbility;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Facades\Auth;

class AbilityService
{
    /** @var Entity */
    protected $entity;

    /** @var array */
    protected $attributes = false;

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
        $abilities = $this->entity->abilities()
            ->select('entity_abilities.*')
            ->with(['ability', 'ability.entity', 'ability.entity.attributes', 'ability.ability', 'ability.ability.entity'])
            ->join('abilities as a', 'a.id', 'entity_abilities.ability_id')
            ->orderBy('a.type')
            ->orderBy('a.name')
            ->get();
        foreach ($abilities as $ability) {
            // Can't read the ability? skip
            if (empty($ability->ability)) {
                continue;
            }
            // If this ability has a parent ability, save it there
            $this->add($ability);
        }

        // Reorder parents
        usort($this->abilities['parents'], function ($a, $b) { return strtoupper($a['name']) > strtoupper($b['name']); });

        // Meta
        $this->abilities['meta'] = [
            'add_url' => route('entities.entity_abilities.create', $this->entity),
            'user_id' => Auth::check() ? Auth::user()->id : 0,
            'is_admin' => Auth::check() && Auth::user()->isAdmin(),
        ];

        return $this->abilities;
    }

    /**
     * Reset all charges
     * @return $this
     */
    public function resetCharges(): self
    {
        $usedAbilities = $this->entity->abilities()->where('charges', '>', 0)->get();
        foreach ($usedAbilities as $ability) {
            $ability->charges = null;
            $ability->save();
        }

        return $this;
    }

    /**
     * Use an ability charge
     * @param EntityAbility $entityAbility
     * @param int $used
     * @return bool
     */
    public function useCharge(EntityAbility $entityAbility, int $used): bool
    {
        // Check that we are not above the parent
        if ($used > $this->parseCharges($entityAbility->ability)) {
            return false;
        }

        $entityAbility->charges = $used;
        $entityAbility->save();

        return true;
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
        $data = [
            'ability_id' => $entityAbility->ability_id,
            'name' => $entityAbility->ability->name,
            'entry' => $entityAbility->ability->entry(),
            'type' => $entityAbility->ability->type,
            'charges' => $this->parseCharges($entityAbility->ability),
            'used_charges' => $entityAbility->charges,
            'visibility' => $entityAbility->visibility,
            'created_by' => $entityAbility->created_by,
            'attributes' => $this->attributes($entityAbility->ability->entity),
            'actions' => [
                'edit' => route('entities.entity_abilities.update', [$this->entity, $entityAbility]),
                'delete' => route('entities.entity_abilities.destroy', [$this->entity, $entityAbility]),
            ],
        ];

        if (!empty($entityAbility->ability->charges)) {
            $data['actions']['use'] = route('entities.entity_abilities.use', [$this->entity, $entityAbility]);
        }

        return $data;
    }

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

    /**
     * @param Ability $ability
     * @return int|string|null
     */
    protected function parseCharges(Ability $ability)
    {
        if (empty($ability->charges)) {
            return null;
        }

        if (is_int($ability->charges)) {
            return $ability->charges;
        }
        try {
            // Replace {} with entity attributes
            $charge = preg_replace_callback('`\{(.*?)\}`i', function ($matches) {
                $text = $matches[1];
                if ($this->entityAttributes()->has($text)) {
                    return $this->entityAttributes()->get($text);
                }
                return 0;
            }, $ability->charges);

            $calculator = new StringCalc();
            return $calculator->calculate($charge);
        } catch(\Exception $e) {
            return null;
        }
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    protected function entityAttributes()
    {
        if ($this->attributes !== false) {
            return $this->attributes;
        }

        return $this->attributes = $this->entity->attributes()->pluck('value', 'name');
    }
}
