<?php

namespace App\Services\Entity;

use App\Facades\Mentions;
use App\Models\Ability;
use App\Models\Attribute;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Traits\EntityAware;
use ChrisKonnertz\StringCalc\StringCalc;
use Illuminate\Support\Collection;
use App\Http\Requests\ReorderAbility;
use Exception;

class AbilityService
{
    use EntityAware;

    /** @var Collection|bool */
    protected Collection|bool $attributes = false;

    /** @var array All the abilities of this entity, nicely prepared */
    protected array $abilities = [
        'parents' => [],
        'abilities' => [],
        'meta' => []
    ];

    /** @var array A list of abilities that have already been loaded */
    protected array $abilityIds = [];

    /**
     * @return array
     */
    public function abilities(): array
    {
        $abilities = $this->entity->abilities()
            ->select('entity_abilities.*')
            ->with(['ability',
                // entity
                'ability.entity', 'ability.entity.image', 'ability.entity.attributes',
                // parent
                'ability.ability', 'ability.ability.entity', 'ability.ability.entity.tags',
            ])
            ->join('abilities as a', 'a.id', 'entity_abilities.ability_id')
            ->defaultOrder()
            ->get();
        /** @var EntityAbility $ability */
        foreach ($abilities as $key => $ability) {
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
        /** @var Ability $ability */
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
     * @param EntityAbility $entityAbility
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
                'image' => $parent->thumbnail(120),
                'has_image' => !empty($parent->image),
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
     * @param EntityAbility $entityAbility
     * @return array
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
                'has' => !empty($entityAbility->ability->image) || $entityAbility->ability->entity->image,
                'thumb' => $entityAbility->ability->thumbnail(120),
                'url' => !empty($entityAbility->ability->image) ? $entityAbility->ability->getOriginalImageUrl() : null,
            ],
            'actions' => [
                'edit' => route('entities.entity_abilities.edit', [$this->entity, $entityAbility]),
                'update' => route('entities.entity_abilities.update', [$this->entity, $entityAbility]),
                'delete' => route('entities.entity_abilities.destroy', [$this->entity, $entityAbility]),
                'view' => route('abilities.show', $entityAbility->ability_id),
            ],
            'entity' => [
                'id' => $entityAbility->ability->entity->id,
                'tooltip' => route('entities.tooltip', $entityAbility->ability->entity->id)
            ]
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            return $entry;
        }
    }

    /**
     * @param string $haystack
     * @param bool $calc
     * @return float|int|string|null
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
        if (!$this->entity->isCharacter()) {
            throw new Exception('not_character');
        }
        /** @var Character $character */
        $character = $this->entity->child;
        if (empty($character->races)) {
            throw new Exception('no_race');
        }
        $count = 0;

        // Existing abilities
        $abilities = $this->entity->abilities;
        $existingIds = [];
        foreach ($abilities as $ability) {
            // The ability is soft deleted so we can skip it
            // @phpstan-ignore-next-line
            if (empty($ability) || empty($ability->ability)) {
                continue;
            }
            $existingIds[] = $ability->ability_id;
        }

        foreach ($character->races()->with('entity')->get() as $race) {
            /** @var EntityAbility[] $abilities */
            $abilities = $race->entity->abilities;
            $count = 0;
            foreach ($abilities as $ability) {
                // If it's deleted or already on this entity, skip
                if (empty($ability->ability) || in_array($ability->ability_id, $existingIds)) {
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

    /**
     * @param ReorderAbility $request
     * @return bool
     */
    public function reorder(ReorderAbility $request): bool
    {
        $ids = $request->get('ability');

        if (empty($ids)) {
            return false;
        }

        $position = 1;
        foreach ($ids as $id) {
            /** @var EntityAbility|null $ability */
            $ability = EntityAbility::find($id);
            if ($ability === null || $ability->entity_id !== $this->entity->id) {
                continue;
            }

            $ability->position = $position;
            $ability->save();
            $position++;
        }
        return true;
    }
}
