<?php


namespace App\Services\Entity;


use App\Models\Character;
use App\Models\Entity;
use App\Models\Family;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Models\Relation;
use Illuminate\Support\Arr;

class EntityRelationService
{
    /** @var Entity */
    protected $entity;

    /** @var array Entities */
    protected $entities = [];

    /** @var array Relations */
    protected $relations = [];

    /** @var array Loaded relation IDS */
    protected $relationIds = [];

    /** @var array Mirrored IDs */
    protected $mirrors = [];

    protected $family = false;
    protected $organisation = false;

    /**
     * @param Entity $entity
     * @return $this
     */
    public function entity(Entity $entity): self
    {
        $this->entity = $entity;
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

    /**
     * @return array
     */
    public function map(): array
    {
        // Prepare self
        $this->addEntity($this->entity);

        // Family and orgs
        if ($this->entity->typeId() == config('entities.ids.character')) {
            $this->addFamily()->addOrganisations();
        }

        return ['relations' => $this->relations, 'entities' => $this->entities];
    }

    /**
     * @param Entity $entity
     */
    protected function addEntity(Entity $entity, bool $withRelations = true, string $image = null): self
    {
        if (Arr::has($this->entities, $entity->id)) {
            return $this;
        }

        $this->entities[$entity->id] = [
            'id' => $entity->id,
            'name' => $entity->name . ($this->family || $this->organisation ? ' (' . __('entities.' . $entity->type) . ')' : null),
            'image' => $image ?? $entity->child->getImageUrl(80, 80),
            'link' => $entity->url(),
        ];

        // Reset
        $this->family(false)->organisation(false);

        // Check relations of entity
        if (!$withRelations) {
            return $this;
        }
        $this->addRelations($entity);
        return $this;
    }

    protected function addRelations(Entity $entity, bool $limitToExisting = false)
    {
        // Get the relations directly from this entity
        /** @var Relation[] $relations */
        $relations = $entity->relationships()
            ->select('relations.*')
            ->with('target')
            ->has('target')
            ->leftJoin('entities as t', 't.id', '=', 'relations.target_id')
            ->acl()
            ->get();
        foreach ($relations as $relation) {
            if (!$relation->target) {
                continue;
            }
            if (!$limitToExisting) {
                $this->addEntity($relation->target);
            } elseif ($limitToExisting) {
                if (!Arr::has($this->entities, $relation->target_id)) {
                    continue;
                }
            }

            // Don't add mirrored relations
            if ($relation->mirrored()) {
                if (Arr::has($this->mirrors, $relation->mirror_id . '-' . $relation->id)) {
                    continue;
                }
            }
            // Relation already loaded
            if (in_array($relation->id, $this->relationIds)) {
                continue;
            }

            $this->relations[] = [
                'source' => $relation->owner_id,
                'target' => $relation->target_id,
                'text' => $relation->relation,
                'colour' => $relation->colour,
                'attitude' => $relation->attitude,
                'type' => 'entity-relation',
                'is_mirrored' => $relation->mirrored(),
                'shape' => $relation->mirrored() ? 'none' : 'triangle',
            ];

            if ($relation->mirrored()) {
                $this->mirrors[$relation->id . '-' . $relation->mirror_id] = true;
            }
            $this->relationIds[] = $relation->id;
        }
    }

    protected function addFamily() : self
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
        $this->family()->addEntity($family->entity, false);

        /** @var Character $member */
        foreach ($family->members()->with('entity')->has('entity')->get() as $member) {
            $this->addEntity($member->entity, false, $member->entity->getImageUrl(80, 80));

            // Add relation
            $this->relations[] = [
                'source' => $family->entity->id,
                'target' => $member->entity->id,
                'text' => __('families.fields.members'),
                'colour' => null,
                'attitude' => null,
                'type' => 'family-member',
                'shape' => 'none',
            ];

            //dump('adding family member ' . $member->entity->name . '(' . $member->entity->id . ') to ' . $family->name);
        }
    }

    protected function addOrganisations() : self
    {
        /** @var Character $character */
        $character = $this->entity->child;
        $organisations = $character->organisations()
            ->has('organisation')
            ->with(['organisation', 'organisation.entity'])
            ->get();
        foreach ($organisations as $org) {
            if ($org->organisation && $org->organisation->entity) {
                $this->addOrganisationRelations($org->organisation);
            }
        }
        return $this;
    }

    protected function addOrganisationRelations(Organisation $organisation)
    {
        if (empty($organisation) || empty($organisation->entity)) {
            return;
        }
        $this->organisation()->addEntity($organisation->entity, false);

        /** @var OrganisationMember $member */
        foreach ($organisation->members()->with('character.entity')->has('character.entity')->get() as $member) {
            if (empty($member->character->entity)) {
                return;
            }
            $this->addEntity($member->character->entity, false, $member->character->getImageUrl(80, 80));


            // Add relation
            $this->relations[] = [
                'source' => $organisation->entity->id,
                'target' => $member->character->entity->id,
                'text' => $member->role,
                'colour' => null,
                'attitude' => null,
                'type' => 'org-member',
                'shape' => 'none',
            ];

            // Show relations of org members if the target is shown here
            $this->addRelations($member->character->entity, true);

        }
    }
}
