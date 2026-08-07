<?php

namespace App\Services\Families;

use App\Enums\FamilyTreeChildType;
use App\Enums\Visibility;
use App\Facades\Avatar;
use App\Models\Entity;
use App\Models\Family;
use App\Models\FamilyTree;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Validation\ValidationException;

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

    protected array $graph = [];

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
            'version' => FamilyTreeGraph::VERSION,
            'nodes' => $this->graph['nodes'] ?? [],
            'edges' => $this->graph['edges'] ?? [],
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
        $this->loadFamilyTree();
        $this->loadFamily();

        // Get all the entity ids
        $this->graph = FamilyTreeGraph::normalize($this->familyTree->config);
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
            if (isset($this->user)) {
                $familyTree->save();
            }
            $this->family->setRelation('familyTree', $familyTree);
        }
        $this->familyTree = $familyTree;
    }

    /**
     * Get all the unique entity ids from the family tree
     */
    protected function prepareEntities(): void
    {
        $data = $this->graph;
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
            $this->config = $this->graph;
            $this->visibilityCheck();

            return;
        }

        $this->entityIds = array_unique(array_values($this->configEntityIds));
        // dump($this->entityIds);

        // Prepare entities
        $entities = Entity::inTypes([config('entities.ids.character')])
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
        // dump($this->entities);
        if (! empty($this->entities)) {
            $this->missingIds = array_diff($this->entityIds, array_keys($this->entities));
            $this->cleanupMissingEntities();
            $this->visibilityCheck();
        } else {
            $this->entities = [];
            $this->graph = FamilyTreeGraph::empty();
            $this->config = $this->graph;
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
        $visibleNodes = array_filter($this->graph['nodes'], fn (array $node) => $this->isVisible($node));
        $visibleNodeIds = array_fill_keys(array_column($visibleNodes, 'id'), true);
        $visibleEdges = array_filter($this->graph['edges'], function (array $edge) use ($visibleNodeIds): bool {
            return isset($visibleNodeIds[$edge['source']], $visibleNodeIds[$edge['target']]) && $this->isVisible($edge);
        });
        $this->graph = [
            'version' => FamilyTreeGraph::VERSION,
            'nodes' => array_values($visibleNodes),
            'edges' => array_values($visibleEdges),
        ];
        $this->config = $this->graph;
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
            $this->config = $this->familyTree->config;

            return;
        }

        $missingNodeIds = [];
        foreach ($this->graph['nodes'] as $node) {
            if (in_array($node['entity_id'] ?? null, $this->missingIds, true)) {
                $missingNodeIds[$node['id']] = true;
            }
        }
        $this->graph['nodes'] = array_values(array_filter(
            $this->graph['nodes'],
            fn (array $node): bool => ! isset($missingNodeIds[$node['id']])
        ));
        $this->graph['edges'] = array_values(array_filter(
            $this->graph['edges'],
            fn (array $edge): bool => ! isset($missingNodeIds[$edge['source']], $missingNodeIds[$edge['target']])
        ));
        $this->config = $this->graph;
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
        // If the campaign is not premium dont save the tree.
        if (! $this->campaign->premium()) {
            return $this;
        }

        $this->loadFamilyTree();
        if (empty($data)) {
            $this->familyTree->config = FamilyTreeGraph::empty();
            $this->familyTree->save();

            return $this;
        }

        // $data = json_decode($data);
        $data = FamilyTreeGraph::normalize($data);
        FamilyTreeGraph::validate($data);
        $this->validateEntities($data);

        $this->familyTree->config = $data;
        $this->familyTree->save();

        $this->graph = $data;
        $this->config = $data;

        return $this;
    }

    protected function validateEntities(array $graph): void
    {
        $entityIds = collect($graph['nodes'])
            ->pluck('entity_id')
            ->filter()
            ->unique()
            ->values();
        if ($entityIds->isEmpty()) {
            return;
        }

        $validIds = Entity::query()
            ->where('campaign_id', $this->campaign->id)
            ->inTypes([config('entities.ids.character')])
            ->whereIn('id', $entityIds)
            ->pluck('id');
        if ($validIds->count() !== $entityIds->count()) {
            throw ValidationException::withMessages(['data' => 'Family trees can only contain characters from this campaign.']);
        }
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
                        'custom_required' => __('families/trees.modals.entity.child.custom_required'),
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
                    'partner_status' => __('families/trees.modals.fields.partner_status'),
                    'child_type' => __('families/trees.modals.fields.child_type'),
                    'custom_role' => __('families/trees.modals.fields.custom_role'),
                    'types' => [
                        'biological' => __('families/trees.modals.fields.types.biological'),
                        'adopted' => __('families/trees.modals.fields.types.adopted'),
                        'step' => __('families/trees.modals.fields.types.step'),
                        'foster' => __('families/trees.modals.fields.types.foster'),
                        'custom' => __('families/trees.modals.fields.types.custom'),
                    ],
                    'partners' => [
                        'current' => __('families/trees.modals.fields.partners.current'),
                        'former' => __('families/trees.modals.fields.partners.former'),
                    ],
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
            'child_types' => [
                0 => [
                    'label' => __('families/trees.modals.fields.types.mixed'),
                    'icon' => 'fa-solid fa-tags',
                ],
                FamilyTreeChildType::Biological->value => [
                    'label' => __('families/trees.modals.fields.types.biological'),
                    'icon' => 'fa-solid fa-dna',
                ],
                FamilyTreeChildType::Adopted->value => [
                    'label' => __('families/trees.modals.fields.types.adopted'),
                    'icon' => 'fa-solid fa-house-heart',
                ],
                FamilyTreeChildType::Step->value => [
                    'label' => __('families/trees.modals.fields.types.step'),
                    'icon' => 'fa-solid fa-people-arrows',
                ],
                FamilyTreeChildType::Foster->value => [
                    'label' => __('families/trees.modals.fields.types.foster'),
                    'icon' => 'fa-solid fa-hand-holding-heart',
                ],
                FamilyTreeChildType::Custom->value => [
                    'label' => __('families/trees.modals.fields.types.custom'),
                    'icon' => 'fa-solid fa-tag',
                ],
            ],
        ];
    }
}
