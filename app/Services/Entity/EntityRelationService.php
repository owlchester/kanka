<?php

namespace App\Services\Entity;

use App\Models\Character;
use App\Models\Concerns\Nested;
use App\Models\Conversation;
use App\Models\DiceRoll;
use App\Models\Entity;
use App\Models\EntityMention;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\MapMarker;
use App\Models\MiscModel;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Models\QuestElement;
use App\Models\Race;
use App\Models\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EntityRelationService
{
    /** @var Entity */
    protected Entity $entity;

    /** @var array Entities */
    protected array $entities = [];

    /** @var array Relations */
    protected array $relations = [];

    /** @var array Loaded relation IDS */
    protected array $relationIds = [];

    /** @var array Loaded org members to avoid things getting messy */
    protected array $orgMembers = [];

    /** @var array Mirrored IDs */
    protected array $mirrors = [];

    protected bool $family = false;
    protected bool $organisation = false;

    /** @var array Entities that have had their relations already loaded */
    protected array $entityIds = [];

    /** @var bool Enable or disable relations */
    protected bool $withRelations = true;

    /** @var bool Enable loading entities on relations */
    protected bool $withEntity = false;

    /** @var string|null  */
    protected string|null $option = null;

    /**
     * @param Entity $entity
     * @return $this
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    public function option(string $option = null): self
    {
        if (!in_array($option, ['related', 'mentions', 'only_relations'])) {
            $option = null;
        }
        $this->option = $option;
        return $this;
    }

    protected function family(bool $family = true): self
    {
        $this->family = $family;
        return $this;
    }

    protected function organisation(bool $organisation = true): self
    {
        $this->organisation = $organisation;
        return $this;
    }

    protected function withoutRelations(bool $without = true): self
    {
        $this->withRelations = !$without;
        return $this;
    }

    protected function withEntity(bool $with = true): self
    {
        $this->withEntity = $with;
        return $this;
    }

    /**
     * @return array
     */
    public function map(): array
    {
        $entityHook = 'init' . ucfirst($this->entity->type());
        if (method_exists($this, $entityHook)) {
            $this->$entityHook();
        } else {
            // Other: just relations
            $this->addEntity($this->entity)
                ->withEntity();

            $this->loadRelations();

            if ($this->withRelated()) {
                $this->addParent()
                    ->addLocation()
                    ->addQuests()
                    ->addAuthorJournals()
                    ->addMapMarkers()
                    ->addLocations();
            }
        }

        $this->addMentions();

        $this->cleanup();
        return ['relations' => $this->relations, 'entities' => $this->entities];
    }

    /**
     * Remove any relations that don't match up
     */
    protected function cleanup()
    {
        $relations = [];
        foreach ($this->relations as $relation) {
            if (
                isset($this->entities[$relation['source']]) &&
                isset($this->entities[$relation['target']])
            ) {
                $relations[] = $relation;
            }
        }

        $this->relations = $relations;
    }

    /**
     * @param Entity $entity
     * @param string|null $image
     * @return $this
     */
    protected function addEntity(Entity $entity, string $image = null): self
    {
        //dump('add entity ' . $entity->name);
        if (Arr::has($this->entities, (string) $entity->id)) {
            return $this;
        }
        if (empty($entity->child)) {
            return $this;
        }

        $img = $image ?? $entity->child->thumbnail(80, 80);
        if (empty($img)) {
            // Fallback?
            $img = '';
        }
        $params = [$entity->id, 'mode' => 'map'];
        if ($this->option) {
            $params['option'] = $this->option;
        }
        $this->entities[$entity->id] = [
            'id' => $entity->id,
            'name' => $entity->name . "\n(" . $entity->entityType() . ')',
            'image' => $img,
            'link' => route('entities.relations.index', $params),
            //'tooltip' => route('entities.tooltip', $entity->id)
        ];
        return $this;
    }

    /**
     * @param Entity $entity
     * @return $this
     */
    protected function addRelations(Entity $entity): self
    {
        //dump('add relations for ' . $entity->name);
        if (Arr::has($this->entityIds, (string) $entity->id)) {
            return $this;
        }
        $this->entityIds[$entity->id] = true;

        // Get the relations directly from this entity
        /** @var Relation[] $relations */
        $relations = $entity->relationships()
            ->select('relations.*')
            ->with('target')
            ->has('target')
            ->leftJoin('entities as t', 't.id', '=', 'relations.target_id')
            ->get();

        foreach ($relations as $relation) {
            if ($relation->target === null) {
                continue;
            }

            // Don't add mirrored relations
            if ($relation->isMirrored()) {
                if (Arr::has($this->mirrors, $relation->mirror_id . '-' . $relation->id)) {
                    continue;
                }
            }
            // Relation already loaded
            if (in_array($relation->id, $this->relationIds)) {
                continue;
            }

            if ($this->withEntity) {
                $this->addEntity($relation->target);
            }

            $this->relations[] = [
                'source' => $relation->owner_id,
                'target' => $relation->target_id,
                'text' => $relation->relation,
                'colour' => $relation->colour,
                'attitude' => $relation->attitude,
                'type' => 'entity-relation',
                'is_mirrored' => $relation->isMirrored(),
                'shape' => $relation->isMirrored() ? 'none' : 'triangle',
                'edit_url' => route('entities.relations.edit', [
                    'entity' => $relation->owner_id,
                    'relation' => $relation,
                    'from' => $this->entity->id,
                    'mode' => 'map',
                    'option' => $this->option
                ])
            ];

            if ($relation->isMirrored()) {
                $this->mirrors[$relation->id . '-' . $relation->mirror_id] = true;
            }
            $this->relationIds[] = $relation->id;
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function addFamily(): self
    {
        if (empty($this->entity->child->family)) {
            return $this;
        }

        $family = $this->entity->child->family;

        $this->addFamilyRelations($family);

        // Add relation to the family
        return $this;
    }

    /**
     * Add the family or a character and the family's members
     * @param Family $family
     */
    protected function addFamilyRelations(Family $family)
    {
        /** @var Family $family */
        $this->family()->addEntity($family->entity)->addRelations($family->entity);

        $this->addFamilyMembers($family);
    }

    /**
     * @return $this
     */
    protected function addOrganisation(): self
    {
        /** @var Character $character */
        $character = $this->entity->child;
        $organisations = $character->organisationMemberships()
            ->has('organisation')
            ->with(['organisation', 'organisation.entity'])
            ->get();
        foreach ($organisations as $org) {
            if ($org->organisation !== null && $org->organisation->entity !== null) {
                $this->addOrganisationRelations($org->organisation);
            }
        }
        return $this;
    }

    /**
     * @param Organisation|null $organisation
     */
    protected function addOrganisationRelations(Organisation $organisation = null)
    {
        if (empty($organisation) || $organisation->entity === null) {
            return;
        }
        $this->organisation()->addEntity($organisation->entity);

        /** @var OrganisationMember $member */
        foreach ($organisation->members()->with('character.entity')->has('character.entity')->get() as $member) {
            if (empty($member->character->entity)) {
                return;
            }
            if (isset($this->orgMembers[$member->id])) {
                continue;
            }
            $this->orgMembers[$member->id] = true;
            $this->addEntity($member->character->entity, $member->character->thumbnail(80, 80));

            // Add relation
            $this->relations[] = [
                'source' => $organisation->entity->id,
                'target' => $member->character->entity->id,
                'text' => $member->role,
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'org-member',
                'shape' => 'none',
            ];

            // Show relations of org members if the target is shown here
            $this->addRelations($member->character->entity);
        }
    }

    /**
     * Prepare a family
     */
    protected function initFamily(): self
    {
        $this->addEntity($this->entity)
            ->withEntity()
            ->loadRelations();

        if ($this->withRelated()) {
            /** @var Family $family */
            $family = $this->entity->child;
            $this->addFamilyMembers($family);

            $this->addFamilies()
                ->addParent()
                ->addLocation()
                ->addQuests()
                ->addMapMarkers()
                ->addAuthorJournals()
            ;
        }
        return $this;
    }

    /**
     * @param Family $family
     * @return $this
     */
    protected function addFamilyMembers(Family $family): self
    {
        /** @var Character $member */
        foreach ($family->members()->with(['entity', 'entity.character'])->has('entity')->get() as $member) {
            $this
                ->addEntity($member->entity, $member->entity->character->thumbnail(80, 80))
                ->addRelations($member->entity);

            // Add relation
            $this->relations[] = [
                'source' => $family->entity->id,
                'target' => $member->entity->id,
                'text' => __('entities/relations.types.family_member'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'family-member',
                'shape' => 'none',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addFamilies(): self
    {
        /** @var Family $family */
        $family = $this->entity->child;

        foreach ($family->families()->with('entity')->has('entity')->get() as $subfamily) {
            $this->addEntity($subfamily->entity);
            $this->addRelations($subfamily->entity);

            $this->relations[] = [
                'source' => $subfamily->entity->id,
                'target' => $this->entity->id,
                'text' => __('families.fields.family'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'sub-family',
                'shape' => 'triangle',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function initCharacter(): self
    {
        $this->addEntity($this->entity)
            ->withEntity()
            ->loadRelations();

        if ($this->withRelated()) {
            $this->addFamily()
                ->addOrganisation()
                ->addItems()
                ->addAuthorJournals()
                ->addLocation()
                ->addDiceRolls()
                ->addConversations()
                ->addMapMarkers()
                ->addQuests();
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function initLocation(): self
    {
        $this->addEntity($this->entity)
            ->withEntity()
            ->loadRelations();

        if ($this->withRelated()) {
            $this->relatedRelations()
                ->addCharacters()
                ->addItems()
                ->addFamilies()
                ->addJournals()
                ->addOrganisations()
                ->addParent()
                ->addQuests()
                ->addMapMarkers()
                ->addMaps()
                ->addAuthorJournals()
                ->addRaces()
                ->addLocationCreatures()
            ;
        }


        return $this;
    }

    /**
     * Prepare en organisation
     * @return $this
     */
    protected function initOrganisation(): self
    {
        $this->addEntity($this->entity)
            ->withEntity()
            ->loadRelations();

        if ($this->withRelated()) {
            $this->addOrganisationMembers($this->entity);
            $this
                ->addParent()
                ->addOrganisations()
                ->addLocation()
                ->addQuests()
                ->addMapMarkers()
                ->addAuthorJournals()
            ;
        }

        return $this;
    }

    protected function initMap(): self
    {
        $this->addEntity($this->entity)
            ->withEntity();

        if ($this->withRelations()) {
            $this->addRelations($this->entity);
        }

        if ($this->withRelated()) {
            $this->addParent()
                ->addLocation()
                ->addQuests()
                ->addMapMarkers()
                ->addMaps()
                ->addAuthorJournals()
            ;
        }

        return $this;
    }

    protected function addOrganisationMembers(Entity $entity): self
    {
        /** @var Organisation $organisation */
        $organisation = $entity->child;

        /** @var OrganisationMember[] $members */
        $members = $organisation->members()->with(['character', 'character.entity'])->has('character')->get();
        foreach ($members as $member) {
            $this
                ->addEntity($member->character->entity, $member->character->thumbnail(80, 80))
                ->addRelations($member->character->entity);

            // Add relation
            $this->relations[] = [
                'source' => $entity->id,
                'target' => $member->character->entity->id,
                'text' => __('entities/relations.types.organisation_member'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'family-member',
                'shape' => 'none',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addOrganisations(): self
    {
        /** @var Organisation $organisation */
        $organisation = $this->entity->child;

        foreach ($organisation->organisations()->with('entity')->has('entity')->get() as $sub) {
            $this->addEntity($sub->entity);
            $this->addRelations($sub->entity);

            $this->relations[] = [
                'source' => $sub->entity->id,
                'target' => $this->entity->id,
                'text' => __('entities/relations.types.organisation_member'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'sub-org',
                'shape' => 'triangle',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addCharacters(): self
    {
        /** @var Location $related */
        $related = $this->entity->child;

        foreach ($related->characters()->with('entity')->has('entity')->get() as $sub) {
            $this->addEntity($sub->entity);
            //$this->addRelations($sub->entity);

            $this->relations[] = [
                'target' => $sub->entity->id,
                'source' => $this->entity->id,
                'text' => __('entities.character'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'entity-character',
                'shape' => 'triangle',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addItems(): self
    {
        /** @var Item $parent */
        $parent = $this->entity->child;
        /** @var Item $item */
        foreach ($parent->items()->with('entity')->has('entity')->get() as $item) {
            $this->addEntity($item->entity);
            $this->relations[] = [
                'source' => $this->entity->id,
                'target' => $item->entity->id,
                'text' => __('crud.fields.item'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'entity-item',
                'shape' => 'none',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addJournals(): self
    {
        /** @var Journal $parent */
        $parent = $this->entity->child;
        /** @var Journal $journal */
        foreach ($parent->journals()->with('entity')->has('entity')->get() as $journal) {
            $this->addEntity($journal->entity);
            $this->relations[] = [
                'source' => $this->entity->id,
                'target' => $journal->entity->id,
                'text' => __('crud.fields.journal'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'journal-location',
                'shape' => 'none',
            ];
        }
        return $this;
    }

    protected function addAuthorJournals(): self
    {
        $elements = $this->entity->authoredJournals()->with(['entity'])->has('entity')->get();
        foreach ($elements as $journal) {
            $this->addEntity($journal->entity);
            $this->relations[] = [
                'source' => $this->entity->id,
                'target' => $journal->entity->id,
                'text' => __('journals.fields.author'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'journal-author',
                'shape' => 'none',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addLocation(): self
    {
        if (!array_key_exists('location_id', $this->entity->child->getAttributes())) {
            return $this;
        }
        if (empty($this->entity->child->location_id) || empty($this->entity->child->location)) {
            return $this;
        }

        $this->addEntity($this->entity->child->location->entity);
        $this->relations[] = [
            'source' => $this->entity->id,
            'target' => $this->entity->child->location->entity->id,
            'text' => __('crud.fields.location'),
            'colour' => '#ccc',
            'attitude' => null,
            'type' => 'entity-location',
            'shape' => 'none',
        ];

        return $this;
    }

    /**
     * Add the entity's parent if it has one
     * @return $this
     */
    protected function addParent()
    {
        if (!method_exists($this->entity->child, 'getParentIdName')) {
            // If not part of the node model, check for the {self}_id attribute
            if (!array_key_exists($this->entity->type() . '_id', $this->entity->child->getAttributes())) {
                return $this;
            }
        }

        $relationName = $this->entity->entityType();
        $parent = $this->entity->child->$relationName;
        if (empty($parent)) {
            $this->addChildren($relationName);
            return $this;
        }

        $transKey = $this->entity->pluralType() . '.fields.' . $this->entity->type();

        $this->addEntity($parent->entity);
        $this->relations[] = [
            'source' => $this->entity->id,
            'target' => $parent->entity->id,
            'text' => __($transKey),
            'colour' => '#ccc',
            'attitude' => null,
            'type' => 'entity-parent',
            'shape' => 'triangle',
        ];

        $this->addChildren($relationName);

        return $this;
    }

    /**
     * Assuming the entity has a parent field, it probably has children too
     * @return $this
     */
    protected function addChildren(string $parent): self
    {
        /** @var MiscModel $children */
        $children = Str::plural($parent);
        if (!method_exists($this->entity->child, $children)) {
            return $this;
        }

        foreach ($this->entity->child->$children()->with(['entity'])->has('entity')->get() as $related) {
            $this->addEntity($related->entity);
            $this->relations[] = [
                'target' => $this->entity->id,
                'source' => $related->entity->id,
                'text' => __('crud.fields.child'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'entity-child',
                'shape' => 'triangle',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addDiceRolls(): self
    {
        /** @var Character $parent */
        $parent = $this->entity->child;
        /** @var DiceRoll $related */
        foreach ($parent->diceRolls()->with('entity')->has('entity')->get() as $related) {
            $this->addEntity($related->entity);
            $this->relations[] = [
                'source' => $this->entity->id,
                'target' => $related->entity->id,
                'text' => __('entities.dice_roll'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'character-diceroll',
                'shape' => 'none',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addConversations(): self
    {
        /** @var Character $parent */
        $parent = $this->entity->child;
        /** @var Conversation $related */
        foreach ($parent->conversations()->with('entity')->has('entity')->get() as $related) {
            $this->addEntity($related->entity);
            $this->relations[] = [
                'source' => $this->entity->id,
                'target' => $related->entity->id,
                'text' => __('entities.conversation'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'character-diceroll',
                'shape' => 'none',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addMapMarkers(): self
    {
        /** @var MapMarker $related */
        foreach ($this->entity->mapMarkers()->with(['map', 'map.entity'])->has('map')->get() as $related) {
            $this->addEntity($related->map->entity);
            $this->relations[] = [
                'source' => $this->entity->id,
                'target' => $related->map->entity->id,
                'text' => __('crud.tabs.map-points'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'entity-map-marker',
                'shape' => 'none',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addMaps(): self
    {
        /** @var Map $parent */
        $parent = $this->entity->child;
        /** @var Map $related */
        foreach ($parent->maps()->with(['entity'])->has('entity')->get() as $related) {
            $this->addEntity($related->entity);
            $this->relations[] = [
                'source' => $this->entity->id,
                'target' => $related->entity->id,
                'text' => __('locations.show.tabs.maps'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'location-map',
                'shape' => 'none',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addQuests(): self
    {
        /** @var QuestElement $related */
        foreach ($this->entity->quests()->with(['quest', 'quest.entity'])->has('quest')->get() as $related) {
            $this->addEntity($related->quest->entity);
            $this->relations[] = [
                'source' => $this->entity->id,
                'target' => $related->quest->entity->id,
                'text' => __('entities/relations.connections.quest_element'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'entity-map-point',
                'shape' => 'none',
            ];
        }
        return $this;
    }

    /**
     * Race locations
     * @return $this
     */
    protected function addRaces(): self
    {
        /** @var Race $race */
        $race = $this->entity->child;

        foreach ($race->races()->with('entity')->has('entity')->get() as $subrace) {
            $this->addEntity($subrace->entity);
            $this->addRelations($subrace->entity);

            $this->relations[] = [
                'source' => $subrace->entity->id,
                'target' => $this->entity->id,
                'text' => __('races.fields.race'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'sub-race',
                'shape' => 'triangle',
            ];
        }
        return $this;
    }

    /**
     * Creature locations
     * @return $this
     */
    protected function addLocationCreatures(): self
    {
        /** @var Location $location */
        $location = $this->entity->child;

        foreach ($location->creatures()->with('entity')->has('entity')->get() as $loc) {
            $this->addEntity($loc->entity);
            $this->addRelations($loc->entity);

            $this->relations[] = [
                'source' => $loc->entity->id,
                'target' => $this->entity->id,
                'text' => __('creatures.fields.location'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'location-creature',
                'shape' => 'triangle',
            ];
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addLocations(): self
    {
        /** @var Location $child */
        $child = $this->entity->child;
        if (!method_exists($child, 'locations')) {
            return $this;
        }

        foreach ($child->locations()->with('entity')->has('entity')->get() as $subrace) {
            $this->addEntity($subrace->entity);
            $this->addRelations($subrace->entity);

            $this->relations[] = [
                'source' => $subrace->entity->id,
                'target' => $this->entity->id,
                'text' => __('races.fields.race'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'sub-race',
                'shape' => 'triangle',
            ];
        }
        return $this;
    }


    /**
     * Load relations between linked entities
     * @return $this
     */
    protected function relatedRelations(): self
    {
        // Go through the entities loaded and re-check their relations
        $relatedEntityIds = [];
        /** @var Relation $relation */
        foreach ($this->relations as $relation) {
            $relatedEntityIds[] = $relation['target'];
        }

        $entities = Entity::whereIn('id', $relatedEntityIds)->get();
        foreach ($entities as $entity) {
            $this->addRelations($entity);
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function addMentions(): self
    {
        if (!$this->withMentions()) {
            return $this;
        }

        /** @var EntityMention[] $mentions */
        $mentions = $this->entity->targetMentions()->with('entity')
            ->has('entity')
            ->whereNotNull('entity_id')
            ->get();
        foreach ($mentions as $mention) {
            // Skip mentions to self
            if ($mention->entity_id == $this->entity->id) {
                continue;
            }
            $this->addEntity($mention->entity);
            $this->relations[] = [
                'source' => $this->entity->id,
                'target' => $mention->entity->id,
                'text' => __('entities/relations.connections.mention'),
                'colour' => '#ccc',
                'attitude' => null,
                'type' => 'entity-mention',
                'shape' => 'none',
            ];
        }

        return $this;
    }

    /**
     * @return bool
     */
    protected function withRelations(): bool
    {
        return !$this->onlyRelations();
    }

    /**
     * @return bool
     */
    protected function withRelated(): bool
    {
        return in_array($this->option, ['related', 'mentions']);
    }

    /**
     * @return bool
     */
    protected function withMentions(): bool
    {
        return $this->option === 'mentions';
    }

    /**
     * @return bool
     */
    protected function onlyRelations(): bool
    {
        return $this->option === 'only_relations';
    }

    /**
     * Load the entity's relations, along with optionally the relation's relations
     * @return $this
     */
    protected function loadRelations(): self
    {
        $this
            ->addRelations($this->entity)
            ->withEntity(false);

        if ($this->withRelations()) {
            $this->relatedRelations();
        } elseif ($this->onlyRelations()) {
            // Just requested the entity's relations and target entities, nothing else
        }

        return $this;
    }
}
