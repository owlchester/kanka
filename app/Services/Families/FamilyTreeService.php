<?php

namespace App\Services\Families;

use App\Facades\Avatar;
use App\Models\Entity;
use App\Models\Family;
use App\Models\FamilyTree;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;

class FamilyTreeService
{
    use CampaignAware;
    use UserAware;

    protected Family $family;

    protected FamilyTree $familyTree;

    protected array $entityIds = [];

    protected array $entities = [];

    protected array $missingIds = [];

    protected array $config = [];

    protected array $configEntityIds = [];

    protected array $characterSuggestions = [];

    public function family(Family $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function api()// : array
    {
        $this->loadSetup();

        // return $this->fake();
        return $this->tree();
    }

    public function familyTree()
    {
        return $this->familyTree;
    }

    /**
     * Return all data required to generate the family tree
     */
    public function tree(): array
    {
        return [
            'nodes' => $this->fillNodes(),
            'entities' => $this->entities,
            'suggestions' => $this->characterSuggestions,
            'texts' => $this->texts(),
        ];
    }

    /**
     * Get an entity's representation for the rendering engine
     *
     * @return array|string[]
     */
    public function entity(Entity $entity): array
    {
        if (! $entity->isCharacter()) {
            return ['error' => 'invalid-character'];
        }

        return $this->formatEntity($entity);
    }

    protected function loadSetup(): void
    {
        $this->loadFamilyTree();
        $this->loadFamily();

        // Get all the entity ids
        if (empty($this->familyTree->config)) {
            return;
        }
        $this->prepareEntities();
        // foreach ()
    }

    protected function loadFamily(): void
    {
        $familyMembers = $this->family->allMembers()->with(['entity', 'entity.entityType'])->orderBy('name')->take(10)->get();
        foreach ($familyMembers as $member) {
            $this->characterSuggestions[] = ['id' => $member->entity->id, 'name' => $member->name];
        }
    }

    protected function loadFamilyTree(): void
    {
        $familyTree = $this->family->familyTree;
        if (! $familyTree) {
            $familyTree = new FamilyTree;
            $familyTree->family_id = $this->family->id;
            $familyTree->save();
        }
        $this->familyTree = $familyTree;
    }

    /**
     * Get all the unique entity ids from the family tree
     */
    protected function prepareEntities(): void
    {
        $data = $this->familyTree->config;
        // Go find every unique entity id
        array_walk_recursive($data, function ($v, $k) {
            if ($k !== 'entity_id') {
                return;
            }
            if (empty($v) || in_array($v, $this->configEntityIds)) {
                return;
            }
            $this->configEntityIds[] = $v;
        });
        // Empty family tree
        if (empty($this->configEntityIds)) {
            return;
        }

        $this->entityIds = array_unique(array_values($this->configEntityIds));
        // dump($this->entityIds);

        // Prepare entities
        $entities = Entity::inTypes([config('entities.ids.character')])
            ->with([
                'character' => function ($sub) {
                    return $sub->select('id', 'is_dead');
                },
                'entityType',
                'tags',
                'image',
                'elapsedEvents',
            ])
            ->find($this->entityIds);
        foreach ($entities as $entity) {
            $this->entities[$entity->id] = $this->formatEntity($entity);
        }
        // dump($this->entities);
        if (! empty($this->entities)) {
            $this->missingIds = array_diff($this->entityIds, array_keys($this->entities));
            $this->cleanupMissingEntities();
            $this->visibilityCheck();
        } else {
            $this->entities = [];
            $this->familyTree->config = [];
            // $this->generatePlaceholder();
        }
        // dd($this->characterSuggestions);
        // dump($this->missingIds);
    }

    /**
     * Format an entity for the rendering engine
     */
    protected function formatEntity(Entity $entity): array
    {
        $tags = [];
        foreach ($entity->tags as $tag) {
            $tags[] = 'kanka-tag-' . $tag->id;
            $tags[] = 'kanka-tag-' . $tag->slug;
        }
        $elapsed = $entity->elapsedEvents;

        // Prepare birth and death events
        $birth = null;
        $death = null;
        foreach ($elapsed as $event) {
            if ($event->isBirth() && $birth === null) {
                $birth = $event->year;
            } elseif ($event->isDeath() && $death === null) {
                $death = $event->year;
            }
        }

        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'url' => $entity->url(),
            'thumb' => Avatar::entity($entity)->size(40)->fallback()->thumbnail(),
            'is_dead' => (bool) $entity->character->is_dead,
            'death' => $death,
            'birth' => $birth,
            'tags' => $tags,
        ];
    }

    protected function visibilityCheck(): void
    {
        $config = [];
        foreach ($this->config as $key => $node) {
            $config[$key] = $this->cleanInvisible($node, $key);
        }
        $this->config = $config;
    }

    protected function cleanInvisible($node, $key): mixed
    {
        if (isset($node['relations'])) {
            foreach ($node['relations'] as $k => $rel) {
                if (! isset($rel['children'])) {
                    $relations[] = $rel;

                    continue;
                }

                $children = [];
                foreach ($rel['children'] as $ck => $child) {
                    $child = $this->cleanInvisible($child, $ck);
                    if (! $child) {
                        continue;
                    }
                    if ($this->isVisible($child)) {
                        $children[] = $child;
                    }
                }
                unset($rel['children']);
                if (! empty($children)) {
                    $rel['children'] = $children;
                }
                if ($this->isVisible($rel)) {
                    $relations[] = $rel;
                }
            }
            unset($node['relations']);
            if (! empty($relations)) {
                $node['relations'] = $relations;
            }
        }

        return $node;
    }

    protected function isVisible($relation): bool
    {
        return (bool) (
            ! isset($relation['visibility']) ||
            $relation['visibility'] == \App\Enums\Visibility::All->value ||
            ($relation['visibility'] == \App\Enums\Visibility::Admin->value && isset($this->user) && $this->user->isAdmin()) ||
            ($relation['visibility'] == \App\Enums\Visibility::Member->value && $this->campaign->userIsMember())
        );
    }

    protected function cleanupMissingEntities(): void
    {
        if (empty($this->missingIds)) {
            $this->config = $this->familyTree->config;

            return;
        }

        $config = [];
        // Loop everything and remove entities that match
        foreach ($this->familyTree->config as $key => $node) {
            $config[$key] = $this->cleanupNode($node, $key);
        }

        // Save the config now that its clean?
        $this->config = $config;
    }

    protected function cleanupNode($node, $key): mixed
    {
        if (in_array($node['entity_id'], $this->missingIds) && $node['entity_id'] != null) {
            return null;
        }
        if (! isset($node['relations'])) {
            return null;
        }
        $relations = [];
        foreach ($node['relations'] as $k => $rel) {
            if (in_array($rel['entity_id'], $this->missingIds) && $rel['entity_id'] != null) {
                continue;
            }
            if (! isset($rel['children'])) {
                continue;
            }
            $children = [];
            foreach ($rel['children'] as $ck => $child) {
                $child = $this->cleanupNode($child, $ck);
                if (! $child) {
                    continue;
                }
                $children[] = $child;
            }
            unset($rel['children']);
            if (! empty($children)) {
                $rel['children'] = $children;
            }

            $relations[] = $rel;
        }
        unset($node['relations']);
        if (! empty($relations)) {
            $node['relations'] = $relations;
        }

        /*if (!empty($node['relations'])) {
            $parent[$key]['relations'] = $node['relations'];
        } elseif (isset($node['relations'])) {
            unset($parent[$key]['relations']);
        }*/

        return $node;
    }

    protected function emptyNode(): array
    {
        return [];
    }

    /**
     * Return an error handled by the frontend
     */
    protected function error(string $code): array
    {
        return [
            'error' => true,
            'code' => __($code),
        ];
    }

    /**
     * Save a new tree config to the database
     */
    public function save(array $data = []): self
    {
        $this->loadFamilyTree();
        if (empty($data)) {
            $this->familyTree->config = [];
            $this->familyTree->save();

            return $this;
        }

        // $data = json_decode($data);
        $data = $this->prepareForSave($data);

        $this->familyTree->config = $data;
        $this->familyTree->save();

        return $this;
    }

    /**
     * Prepare a new config for the database by adding a uuid everywhere
     *
     * @return array
     */
    protected function prepareForSave(array $data)// : array
    {
        $assingUuid = function (&$value, $key) {
            if ($key == 'uuid' && (! is_string($value) || ! Str::isUuid($value))) {
                $value = (string) Str::uuid();
            }
            // echo "The key $key has the value $value <br>";
        };

        array_walk_recursive($data, $assingUuid);

        // Loop on the data, adding a uuid on each element that is missing one
        // dd('ended recursive', $data);
        return $data;
    }

    protected function fillNodes(): array
    {
        $nodes = $this->config;
        if (empty($nodes)) {
            return [];
        }
        // dd($nodes);
        if (! isset($nodes[0]['relations'])) {
            return $nodes;
        }

        foreach ($nodes[0]['relations'] as $i => $relation) {
            $nodes[0]['relations'][$i] = $this->informRelation($relation);
        }

        return $nodes;
    }

    protected function informRelation(array $relation): array
    {
        // No children, single relation
        if (empty($relation['children'])) {
            $relation['width'] = 1;

            return $relation;
        }

        $count = 0;
        foreach ($relation['children'] as $i => $child) {
            $count++;
        }
        $relation['width'] = $count;

        return $relation;
    }

    protected function texts(): array
    {
        return [
            'actions' => [
                'edit' => __('crud.edit'),
                'clear' => __('families/trees.actions.clear'),
                'reset' => __('families/trees.actions.reset'),
                'save' => __('families/trees.actions.save'),
                'first' => __('families/trees.actions.first'),
                'founder' => __('families/trees.actions.founder'),
            ],
            'modals' => [
                'clear' => [
                    'confirm' => __('families/trees.modals.clear.confirm'),
                ],
                'relation' => [
                    'add' => [
                        'title' => __('families/trees.modals.relations.add.title'),
                    ],
                    'edit' => [
                        'title' => __('families/trees.modals.relations.edit.title'),
                    ],
                ],
                'entity' => [
                    'add' => [
                        'title' => __('families/trees.modals.entity.add.title'),
                    ],
                    'edit' => [
                        'title' => __('families/trees.modals.entity.edit.title'),
                        'helper' => __('families/trees.modals.entity.edit.helper'),
                    ],
                    'child' => [
                        'title' => __('families/trees.modals.entity.child.title'),
                    ],
                    'founder' => [
                        'title' => __('families/trees.modals.entity.founder.title'),
                    ],
                    'remove' => [
                        'title' => __('crud.remove'),
                        'confirm' => __('families/trees.modals.entity.remove.confirm'),
                    ],
                ],
                'reset' => [
                    'confirm' => __('families/trees.modals.reset.confirm'),
                ],
                'fields' => [
                    'relation' => __('entities/relations.fields.relation'),
                    'character' => __('entities.character'),
                    'member' => __('families/trees.modals.entity.add.member'),
                    'css' => __('dashboard.widgets.fields.class'),
                    'colour' => __('crud.fields.colour'),
                    'unknown' => __('families/trees.modals.relations.unknown'),
                    'founder' => __('families/trees.modals.entity.add.founder'),
                    'visibility' => [
                        'title' => __('crud.fields.visibility'),
                        'all' => __('crud.visibilities.all'),
                        'admins' => __('crud.visibilities.admin'),
                        'members' => __('crud.visibilities.members'),
                    ],
                ],
            ],
            'toasts' => [
                'relations' => [
                    'add' => __('families/trees.modals.relations.add.success'),
                    'edit' => __('families/trees.modals.relations.edit.success'),
                ],
                'entity' => [
                    'add' => __('families/trees.modals.entity.add.success'),
                    'edit' => __('families/trees.modals.entity.edit.success'),
                    'child' => __('families/trees.modals.entity.child.success'),
                    'removed' => __('families/trees.modals.entity.remove.success'),
                ],
                'saved' => __('families/trees.success.saved'),
                'cleared' => __('families/trees.success.cleared'),
                'reseted' => __('families/trees.success.reseted'),
            ],
            'tooltips' => [
                'is_dead' => __('characters.hints.is_dead'),
            ],
            'unknown' => __('families/trees.unknown'),
        ];
    }
}
