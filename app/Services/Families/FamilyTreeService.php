<?php

namespace App\Services\Families;

use App\Models\Character;
use App\Models\Entity;
use App\Models\Family;
use App\Models\FamilyTree;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FamilyTreeService
{
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

    public function api()//: array
    {
        $this->loadSetup();
        //return $this->fake();
        return $this->tree();
    }

    /**
     * Return all data required to generate the family tree
     * @return array
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
     * @param Entity $entity
     * @return array|string[]
     */
    public function entity(Entity $entity): array
    {
        if (!$entity->isCharacter()) {
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
        //foreach ()
    }

    protected function loadFamily(): void
    {
        $familyMembers = $this->family->allMembers()->orderBy('name')->take(10)->get();
        foreach ($familyMembers as $member) {
            $this->characterSuggestions[$member->entity->id] = $member->name;
        }
    }

    protected function loadFamilyTree(): void
    {
        $familyTree = $this->family->familyTree;
        if (!$familyTree) {
            $familyTree = new FamilyTree();
            $familyTree->family_id = $this->family->id;
            $familyTree->save();
        }
        $this->familyTree = $familyTree;
    }

    protected function prepareEntities(): void
    {
        $data = $this->familyTree->config;
        // Go find every unique entity id
        array_walk_recursive($data, function ($v, $k) {
            if ($k !== 'entity_id') {
                return;
            }
            if ($v === 0 || in_array($v, $this->configEntityIds)) {
                return;
            }
            $this->configEntityIds[] = $v;
        });
        // Empty family tree
        if (empty($this->configEntityIds)) {
            return;
        }

        $this->entityIds = array_unique(array_values($this->configEntityIds));
        //dump($this->entityIds);

        // Prepare entities
        $entities = Entity::inTypes([config('entities.ids.character')])
            ->find($this->entityIds);
        foreach ($entities as $entity) {
            $this->entities[$entity->id] = $this->formatEntity($entity);
        }
        //dump($this->entities);
        if (!empty($this->entities)) {
            $this->missingIds = array_diff($this->entityIds, array_keys($this->entities));
            $this->cleanupMissingEntities();
        } else {
            $this->entities = [];
            $this->familyTree->config = [];
            //$this->generatePlaceholder();
        }
        //dd($this->characterSuggestions);
        //dump($this->missingIds);
    }

    /**
     * Format an entity for the rendering engine
     * @param Entity $entity
     * @return array
     */
    protected function formatEntity(Entity $entity): array
    {
        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'url' => $entity->url(),
            'thumb' => $entity->avatar(),
        ];
    }

    protected function cleanupMissingEntities(): void
    {
        if (empty($this->missingIds)) {
            $this->config = $this->familyTree->config;
            return;
        }

        $config = $this->familyTree->config;
        // Loop everything and remove entities that match
        foreach ($config as $key => $node) {
            $this->cleanupNode($config, $node, $key);
        }

        // Save the config now that its clean?
        $this->config = $config;
    }

    protected function cleanupNode(&$parent, $node, $key)
    {
        if (in_array($node['entity_id'], $this->missingIds)) {
            unset($parent[$key]);
            return;
        }
        foreach ($node['relations'] as $k => $rel) {
            if (in_array($rel['entity_id'], $this->missingIds)) {
                unset($node['relations'][$k]);
                continue;
            }
            if (!isset($rel['children'])) {
                continue;
            }
            foreach ($rel['children'] as $ck => $child) {
                $this->cleanupNode($node['relations'][$k]['children'], $child, $ck);
            }
            //$node['relations'][$k] = $rel;
        }
        $parent[$key]['relations'] = $node['relations'];
    }

    protected function emptyNode(): array
    {
        return [];
    }

    /**
     * Return an error handled by the frontend
     * @param string $code
     * @return array
     */
    protected function error(string $code): array
    {
        return [
            'error' => true,
            'code' => __($code)
        ];
    }

    /**
     * Save a new tree config to the database
     * @param string|null $data
     * @return $this
     */
    public function save(array $data = []): self
    {
        $this->loadFamilyTree();
        if (empty($data)) {
            $this->familyTree->config = [];
            $this->familyTree->save();
            return $this;
        }

        //$data = json_decode($data);
        $data = $this->prepareForSave($data);

        $this->familyTree->config = $data;
        $this->familyTree->save();

        return $this;
    }

    /**
     * Prepare a new config for the database by adding a uuid everywhere
     * @param array $data
     * @return array
     */
    protected function prepareForSave(array $data)//: array
    {
        //dd('data', $data);
        $assingUuid = function (&$value, $key) {
            if ($key == 'uuid' && (!is_string($value) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $value) !== 1))) {
                $value = (string) Str::uuid();
            }
            //echo "The key $key has the value $value <br>";
        };

        array_walk_recursive($data, $assingUuid, );
        // Loop on the data, adding a uuid on each element that is missing one
        //dd('ended recursive', $data);
        return $data;
    }

    protected function fillNodes(): array
    {
        $nodes = $this->familyTree->config;
        if (empty($nodes)) {
            return [];
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

        $count = $max = 0;
        foreach($relation['children'] as $i => $child) {
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
                        'title' => __('families/trees.modals.entity.add.title')
                    ],
                    'edit' => [
                        'title' => __('families/trees.modals.entity.edit.title'),
                    ],
                    'child' => [
                        'title' => __('families/trees.modals.entity.child.title'),
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
                    'member' => __('families/trees.modals.entity.add.member')
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
            'unknown' => __('families/trees.unknown'),
        ];
    }
}
