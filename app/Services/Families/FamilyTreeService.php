<?php

namespace App\Services\Families;

use App\Enums\Visibility;
use App\Facades\Avatar;
use App\Models\Entity;
use App\Models\Family;
use App\Models\FamilyTree;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class FamilyTreeService
{
    use CampaignAware;
    use UserAware;

    public function __construct(protected FamilyTreeGraphConverter $graphConverter) {}

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
            'nodes' => $this->config['nodes'] ?? [],
            'edges' => $this->config['edges'] ?? [],
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

        $entity->loadMissing(['status', 'entityType', 'tags', 'image', 'elapsedEvents']);

        return $this->formatEntity($entity);
    }

    protected function loadSetup(): void
    {
        $this->entityIds = [];
        $this->entities = [];
        $this->missingIds = [];
        $this->configEntityIds = [];
        $this->characterSuggestions = [];
        $this->loadFamilyTree();
        $this->loadFamily();
        $this->config = $this->graphConverter->convert($this->familyTree->config ?? []);

        if (! empty($this->config['nodes'])) {
            $this->prepareEntities();
        }
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
            if (isset($this->user)) {
                $familyTree->save();
            }
        }
        $this->familyTree = $familyTree;
    }

    /**
     * Get all the unique entity ids from the family tree
     */
    protected function prepareEntities(): void
    {
        $this->configEntityIds = collect($this->config['nodes'] ?? [])
            ->pluck('entity_id')
            ->filter()
            ->unique()
            ->values()
            ->all();
        $this->entityIds = $this->configEntityIds;

        if (empty($this->entityIds)) {
            return;
        }

        // Prepare entities
        $entities = Entity::inTypes([config('entities.ids.character')])
            ->where('campaign_id', $this->campaign->id)
            ->with([
                'status',
                'entityType',
                'tags',
                'image',
                'elapsedEvents',
            ])
            ->find($this->entityIds);
        foreach ($entities as $entity) {
            $this->entities[$entity->id] = $this->formatEntity($entity);
        }
        $this->missingIds = array_diff($this->entityIds, array_keys($this->entities));
        $this->cleanupMissingEntities();
        $this->visibilityCheck();
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

        $status = null;
        if ($entity->status !== null) {
            $entity->status->setRelation('entityType', $entity->entityType);
            $status = [
                'key' => $entity->status->key,
                'icon' => $entity->status->icon(),
                'name' => $entity->status->name(),
            ];
        }

        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'url' => $entity->url(),
            'thumb' => Avatar::entity($entity)->size(40)->fallback()->thumbnail(),
            'status' => $status,
            'death' => $death,
            'birth' => $birth,
            'tags' => $tags,
        ];
    }

    protected function visibilityCheck(): void
    {
        $nodes = array_values(array_filter(
            $this->config['nodes'] ?? [],
            fn (array $node): bool => $this->isVisible($node)
        ));
        $nodeIds = array_column($nodes, 'id');
        $edges = array_values(array_filter(
            $this->config['edges'] ?? [],
            fn (array $edge): bool => $this->isVisible($edge)
                && in_array($edge['source'] ?? null, $nodeIds, true)
                && in_array($edge['target'] ?? null, $nodeIds, true)
        ));

        $this->config = ['nodes' => $nodes, 'edges' => $edges];
    }

    protected function isVisible($relation): bool
    {
        return (bool) (
            ! isset($relation['visibility']) ||
            $relation['visibility'] == Visibility::All->value ||
            ($relation['visibility'] == Visibility::Admin->value && isset($this->user) && $this->user->can('admin', $this->campaign)) ||
            ($relation['visibility'] == Visibility::Member->value && isset($this->user) && $this->user->can('member', $this->campaign))
        );
    }

    protected function cleanupMissingEntities(): void
    {
        if (empty($this->missingIds)) {
            return;
        }

        $nodes = array_values(array_filter(
            $this->config['nodes'] ?? [],
            fn (array $node): bool => empty($node['entity_id']) || ! in_array($node['entity_id'], $this->missingIds, true)
        ));
        $nodeIds = array_column($nodes, 'id');
        $edges = array_values(array_filter(
            $this->config['edges'] ?? [],
            fn (array $edge): bool => in_array($edge['source'] ?? null, $nodeIds, true)
                && in_array($edge['target'] ?? null, $nodeIds, true)
        ));

        $this->config = ['nodes' => $nodes, 'edges' => $edges];
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
    public function save(?array $data = []): self
    {
        // If the campaign is not premium dont save the tree.
        if (! $this->campaign->premium()) {
            return $this;
        }

        $this->loadFamilyTree();
        if (empty($data)) {
            $this->familyTree->config = [];
            $this->familyTree->save();

            return $this;
        }

        // $data = json_decode($data);
        $data = $this->graphConverter->convert($data);

        $this->familyTree->config = $data;
        $this->familyTree->save();

        return $this;
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
                'pitch' => [
                    'title' => __('concept.premium-feature'),
                    'content' => __('families/trees.pitch'),
                    'more' => __('callouts.premium.learn-more'),
                    'subscription' => __('callouts.actions.subscription'),
                ],
                'reset' => [
                    'confirm' => __('families/trees.modals.reset.confirm'),
                ],
                'fields' => [
                    'relation' => __('entities/relations.fields.role'),
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
            'unknown' => __('families/trees.unknown'),
        ];
    }
}
