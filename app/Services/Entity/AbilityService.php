<?php


namespace App\Services\Entity;


use App\Facades\Mentions;
use App\Models\Ability;
use App\Models\Attribute;
use App\Models\Entity;
use App\Models\EntityAbility;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Exception;

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
            ->defaultOrder()
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
            'user_id' => auth()->check() ? auth()->user()->id : 0,
            'is_admin' => auth()->check() && auth()->user()->isAdmin(),
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
            'entry' => $this->parseEntry($entityAbility->ability),
            'type' => $entityAbility->ability->type,
            'charges' => $this->parseCharges($entityAbility->ability),
            'used_charges' => $entityAbility->charges,
            'note' => nl2br($this->mapAttributes(
                Mentions::mapAny($entityAbility, 'note'), false)
            ),
            'visibility' => $entityAbility->visibility,
            'created_by' => $entityAbility->created_by,
            'attributes' => $this->attributes($entityAbility->ability->entity),
            'actions' => [
                'edit' => route('entities.entity_abilities.edit', [$this->entity, $entityAbility]),
                'update' => route('entities.entity_abilities.update', [$this->entity, $entityAbility]),
                'delete' => route('entities.entity_abilities.destroy', [$this->entity, $entityAbility]),
                'view' => route('abilities.show', $entityAbility->ability_id),
            ],
        ];

        if (!empty($entityAbility->ability->charges)) {
            $data['actions']['use'] = route('entities.entity_abilities.use', [$this->entity, $entityAbility]);
        }

        return $data;
    }

    /**
     * @param Entity $entity
     * @return array
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
            return $this->mapAttributes($ability->charges);
        } catch(\Exception $e) {
            return null;
        }
    }

    /**
     * @param Ability $ability
     * @return float|int|mixed
     */
    protected function parseEntry(Ability $ability)
    {
        $entry = $ability->entry();
        try {
            return $this->mapAttributes($entry, false);
        } catch(\Exception $e) {
            return $entry;
        }
    }

    /**
     * @param Ability $ability
     * @param string $haystack
     * @return float|int
     * @throws \ChrisKonnertz\StringCalc\Exceptions\ContainerException
     * @throws \ChrisKonnertz\StringCalc\Exceptions\NotFoundException
     */
    protected function mapAttributes(string $haystack, bool $calc = true)
    {
        // Replace {} with entity attributes
        $mappedText = preg_replace_callback('`\{(.*?)\}`i', function ($matches) {
            //dd($matches);
            $text = $matches[1];
            if ($this->entityAttributes()->has($text)) {
                return $this->entityAttributes()->get($text);
            }
            return 0;
        }, $haystack);

        if (!$calc) {
            return $mappedText;
        }

        $calculator = new StringCalc();
        return $calculator->calculate($mappedText);
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    protected function entityAttributes()
    {
        if ($this->attributes !== false) {
            return $this->attributes;
        }

        $this->attributes = new Collection();

        /** @var Attribute $attribute */
        foreach ($this->entity->attributes as $attribute) {
            $this->attributes->put($attribute->name, $attribute->mappedValue());
        }

        return $this->attributes;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function import(): int
    {
        if ($this->entity->typeId() !== config('entities.ids.character')) {
            throw new Exception('not_character');
        }
        if (empty($this->entity->child->races)) {
            throw new Exception('no_race');
        }
        $count = 0;

        // Existing abilities
        $abilities = $this->entity->abilities;
        $existingIds = [];
        foreach ($abilities as $ability) {
            // The ability is soft deleted so we can skip it
            if (empty($ability) || empty($ability->ability)) {
                continue;
            }
            $existingIds[] = $ability->ability_id;
        }

        /** @var EntityAbility[] $abilities */
        foreach ($this->entity->child->races()->with('entity')->get() as $race) {
            $abilities = $race->entity->abilities;
            $count = 0;
            foreach ($abilities as $ability) {
                // If it's deleted or already on this entity, skip
                if (empty($ability) || empty($ability->ability) || in_array($ability->ability_id, $existingIds)) {
                    continue;
                }
                $new = $ability->replicate(['entity_id']);
                $new->entity_id = $this->entity->id;
                $new->save();
                $count++;
            }
        }


        return $count;
    }
}
