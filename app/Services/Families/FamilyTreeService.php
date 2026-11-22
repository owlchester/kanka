<?php

namespace App\Services\Families;

use App\Enums\Visibility;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Family;
use App\Models\FamilyTree;
use App\Services\Images\Avatar;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FamilyTreeService
{
    use CampaignAware;
    use UserAware;

    public const VALID_UNION_TYPES = [
        'married',
        'partner',
        'divorced',
        'affair',
        'betrothed',
        'custom',
    ];

    public const VALID_LINK_KINDS = [
        'biological',
        'adopted',
        'foster',
        'step',
        'bastard',
        'custom',
    ];

    public const VALID_DIRECTIONS = ['TB', 'LR'];

    public const VALID_EDGE_STYLES = ['orthogonal', 'smoothstep', 'bezier'];

    protected Family $family;

    protected FamilyTree $familyTree;

    /** @var array<int, array<string, mixed>> */
    protected array $entities = [];

    /** @var array<int, array<int, array<string, mixed>>> */
    protected array $linkedTrees = [];

    /** @var array<string, mixed> */
    protected array $graph = [];

    /** @var array<int, array<string, mixed>> */
    protected array $characterSuggestions = [];

    protected ?int $previewVisibility = null;

    public function family(Family $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function previewVisibility(?int $visibility): self
    {
        if (in_array($visibility, [Visibility::All->value, Visibility::Member->value], true)) {
            $this->previewVisibility = $visibility;
        } else {
            $this->previewVisibility = null;
        }

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function api(): array
    {
        $this->loadSetup();

        return $this->tree();
    }

    public function familyTree(): FamilyTree
    {
        return $this->familyTree;
    }

    /**
     * Return all data required to render and edit the family tree.
     *
     * @return array<string, mixed>
     */
    public function tree(): array
    {
        $characterType = EntityType::find(config('entities.ids.character'));
        $canCreateCharacter = (bool) ($this->user && $characterType && $this->user->can('create', [$characterType, $this->campaign]));

        return [
            'graph' => $this->graph,
            'entities' => (object) $this->entities,
            'linked_trees' => (object) $this->linkedTrees,
            'suggestions' => $this->characterSuggestions,
            'can_create_character' => $canCreateCharacter,
            'is_admin' => (bool) ($this->user && $this->user->can('admin', $this->campaign)),
            'texts' => $this->texts(),
        ];
    }

    /**
     * Get an entity's representation for the rendering engine.
     *
     * @return array<string, mixed>
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
        $this->entities = [];
        $this->linkedTrees = [];
        $this->characterSuggestions = [];

        $this->loadFamilyTree();
        $this->loadFamily();

        $this->graph = FamilyTreeMigrator::toV2($this->familyTree->config);

        if (empty($this->graph['people'])) {
            return;
        }

        $this->prepareEntities();
        $this->loadLinkedTrees();
    }

    protected function loadFamily(): void
    {
        $familyMembers = $this->family->allMembers()
            ->with(['entity', 'entity.entityType'])
            ->orderBy('entities.name')
            ->take(10)
            ->get();

        foreach ($familyMembers as $member) {
            if ($member->entity) {
                $this->characterSuggestions[] = [
                    'id' => $member->entity->id,
                    'name' => $member->entity->name,
                ];
            }
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
                $this->family->setRelation('familyTree', $familyTree);
            }
        }
        $this->familyTree = $familyTree;
    }

    protected function prepareEntities(): void
    {
        $entityIds = FamilyTreeMigrator::extractEntityIds($this->graph);

        if (! empty($entityIds)) {
            $entities = Entity::inTypes([config('entities.ids.character')])
                ->with([
                    'status',
                    'entityType',
                    'tags',
                    'image',
                    'elapsedEvents',
                ])
                ->find($entityIds);

            foreach ($entities as $entity) {
                $this->entities[$entity->id] = $this->formatEntity($entity);
            }
        }

        $this->graph = $this->pruneAndFilterGraph($this->graph);
    }

    /**
     * Load other visible family trees in the same campaign that contain any of the loaded entities.
     */
    protected function loadLinkedTrees(): void
    {
        $entityIds = array_keys($this->entities);
        if (empty($entityIds) || ! $this->familyTree->exists) {
            return;
        }

        $rows = DB::table('family_tree_entities as fte')
            ->join('family_trees as ft', 'ft.id', '=', 'fte.family_tree_id')
            ->join('families as f', 'f.id', '=', 'ft.family_id')
            ->whereIn('fte.entity_id', $entityIds)
            ->where('fte.family_tree_id', '!=', $this->familyTree->id)
            ->where('f.campaign_id', $this->campaign->id)
            ->select('fte.entity_id', 'f.id as family_id')
            ->get();

        if ($rows->isEmpty()) {
            return;
        }

        $familyIds = $rows->pluck('family_id')->unique()->values()->all();

        $visibleFamilies = Entity::query()
            ->where('type_id', config('entities.ids.family'))
            ->whereIn('entity_id', $familyIds)
            ->get(['id', 'entity_id', 'name'])
            ->keyBy('entity_id');

        foreach ($rows as $row) {
            $familyEntity = $visibleFamilies->get((int) $row->family_id);
            if (! $familyEntity) {
                continue;
            }

            $eid = (int) $row->entity_id;
            $this->linkedTrees[$eid][] = [
                'family_id' => (int) $row->family_id,
                'name' => $familyEntity->name,
                'url' => route('families.family-tree', [$this->campaign, $row->family_id]) . '?focus=' . $eid,
            ];
        }
    }

    /**
     * Format an entity for the rendering engine.
     *
     * @return array<string, mixed>
     */
    protected function formatEntity(Entity $entity): array
    {
        $tags = [];
        foreach ($entity->tags as $tag) {
            $tags[] = 'kanka-tag-' . $tag->id;
            $tags[] = 'kanka-tag-' . $tag->slug;
        }
        $elapsed = $entity->elapsedEvents;

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
            'thumb' => Avatar::for($entity)->size(80)->fallback()->thumbnail(),
            'status' => $status,
            'death' => $death,
            'birth' => $birth,
            'tags' => $tags,
        ];
    }

    /**
     * Prune missing/inaccessible entities and filter by visibility.
     *
     * @param  array<string, mixed>  $graph
     * @return array<string, mixed>
     */
    protected function pruneAndFilterGraph(array $graph): array
    {
        $keptPeople = [];
        $keptPersonIds = [];

        foreach ($graph['people'] ?? [] as $person) {
            if (! is_array($person) || empty($person['id'])) {
                continue;
            }

            $entityId = $person['entity_id'] ?? null;
            if ($entityId !== null && ! isset($this->entities[(int) $entityId])) {
                continue;
            }

            if (! $this->isVisible($person)) {
                continue;
            }

            $keptPeople[] = $person;
            $keptPersonIds[(string) $person['id']] = true;
        }

        $keptUnions = [];
        $keptUnionIds = [];

        foreach ($graph['unions'] ?? [] as $union) {
            if (! is_array($union) || empty($union['id'])) {
                continue;
            }
            if (! $this->isVisible($union)) {
                continue;
            }

            $partners = array_values(array_filter(
                is_array($union['partners'] ?? null) ? $union['partners'] : [],
                fn (mixed $pid): bool => is_string($pid) && isset($keptPersonIds[$pid])
            ));

            if (empty($partners)) {
                continue;
            }

            $union['partners'] = $partners;
            $keptUnions[] = $union;
            $keptUnionIds[(string) $union['id']] = true;
        }

        $keptLinks = [];
        foreach ($graph['links'] ?? [] as $link) {
            if (! is_array($link) || empty($link['id'])) {
                continue;
            }
            if (! $this->isVisible($link)) {
                continue;
            }

            $childId = isset($link['child_id']) ? (string) $link['child_id'] : '';
            if ($childId === '' || ! isset($keptPersonIds[$childId])) {
                continue;
            }

            $unionId = isset($link['union_id']) && is_string($link['union_id']) && $link['union_id'] !== ''
                ? $link['union_id']
                : null;
            $parentId = isset($link['parent_id']) && is_string($link['parent_id']) && $link['parent_id'] !== ''
                ? $link['parent_id']
                : null;

            if ($unionId !== null) {
                if (! isset($keptUnionIds[$unionId])) {
                    continue;
                }
            } elseif ($parentId === null || ! isset($keptPersonIds[$parentId])) {
                continue;
            }

            $keptLinks[] = $link;
        }

        return [
            'version' => FamilyTreeMigrator::VERSION,
            'settings' => $graph['settings'] ?? FamilyTreeMigrator::empty()['settings'],
            'people' => $keptPeople,
            'unions' => $keptUnions,
            'links' => $keptLinks,
        ];
    }

    /**
     * @param  array<string, mixed>  $item
     */
    protected function isVisible(array $item): bool
    {
        $visibility = isset($item['visibility']) && is_numeric($item['visibility'])
            ? (int) $item['visibility']
            : Visibility::All->value;

        if ($this->previewVisibility !== null && isset($this->user) && $this->user->can('admin', $this->campaign)) {
            if ($this->previewVisibility === Visibility::All->value) {
                return $visibility === Visibility::All->value;
            }

            if ($this->previewVisibility === Visibility::Member->value) {
                return in_array($visibility, [Visibility::All->value, Visibility::Member->value], true);
            }
        }

        return (bool) (
            $visibility === Visibility::All->value
            || ($visibility === Visibility::Admin->value && isset($this->user) && $this->user->can('admin', $this->campaign))
            || ($visibility === Visibility::Member->value && isset($this->user) && $this->user->can('member', $this->campaign))
        );
    }

    /**
     * Save a new tree config to the database.
     *
     * @param  array<string, mixed>  $data
     */
    public function save(array $data = []): self
    {
        if (! $this->campaign->premium()) {
            return $this;
        }

        $this->loadFamilyTree();
        if (empty($data)) {
            $this->familyTree->config = [];
            $this->familyTree->save();
            $this->family->setRelation('familyTree', $this->familyTree);

            return $this;
        }

        $normalized = $this->prepareForSave($data);

        $this->familyTree->config = $normalized;
        $this->familyTree->save();
        $this->family->setRelation('familyTree', $this->familyTree);

        return $this;
    }

    /**
     * Normalize and validate a v2 (or v1) payload for persistence.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function prepareForSave(array $data): array
    {
        $graph = FamilyTreeMigrator::toV2($data);
        $defaults = FamilyTreeMigrator::empty()['settings'];
        $settings = is_array($graph['settings'] ?? null) ? $graph['settings'] : [];

        $direction = in_array($settings['direction'] ?? null, self::VALID_DIRECTIONS, true)
            ? $settings['direction']
            : $defaults['direction'];
        $edgeStyle = in_array($settings['edgeStyle'] ?? null, self::VALID_EDGE_STYLES, true)
            ? $settings['edgeStyle']
            : $defaults['edgeStyle'];
        $compact = (bool) ($settings['compact'] ?? $defaults['compact']);

        $personIdMap = [];
        $people = [];
        foreach ($graph['people'] as $person) {
            if (! is_array($person)) {
                continue;
            }
            $oldId = isset($person['id']) && is_string($person['id']) ? $person['id'] : null;
            $id = $this->ensureUuid($oldId);
            if ($oldId !== null && $oldId !== '') {
                $personIdMap[$oldId] = $id;
            }
            $entityId = isset($person['entity_id']) && is_numeric($person['entity_id']) && (int) $person['entity_id'] > 0
                ? (int) $person['entity_id']
                : null;

            $placeholder = null;
            if ($entityId === null) {
                $rawPlaceholder = is_array($person['placeholder'] ?? null) ? $person['placeholder'] : [];
                $placeholder = [
                    'name' => mb_substr(trim((string) ($rawPlaceholder['name'] ?? '')), 0, 191),
                    'subtitle' => mb_substr(trim((string) ($rawPlaceholder['subtitle'] ?? '')), 0, 191),
                ];
            }

            $people[] = [
                'id' => $id,
                'entity_id' => $entityId,
                'placeholder' => $placeholder,
                'colour' => $this->sanitizeNullableString($person['colour'] ?? null, 20),
                'cssClass' => $this->sanitizeNullableString($person['cssClass'] ?? null, 70),
                'visibility' => $this->sanitizeVisibility($person['visibility'] ?? null),
            ];
        }

        $unionIdMap = [];
        $unions = [];
        foreach ($graph['unions'] as $index => $union) {
            if (! is_array($union)) {
                continue;
            }
            $partners = array_values(array_unique(array_filter(
                array_map(
                    fn (mixed $pid): string => is_string($pid) ? ($personIdMap[$pid] ?? $pid) : '',
                    is_array($union['partners'] ?? null) ? $union['partners'] : []
                ),
                fn (string $pid): bool => $pid !== ''
            )));
            if (empty($partners)) {
                continue;
            }
            $oldUnionId = isset($union['id']) && is_string($union['id']) ? $union['id'] : null;
            $unionId = $this->ensureUuid($oldUnionId);
            if ($oldUnionId !== null && $oldUnionId !== '') {
                $unionIdMap[$oldUnionId] = $unionId;
            }
            $type = in_array($union['type'] ?? null, self::VALID_UNION_TYPES, true)
                ? $union['type']
                : 'married';

            $unions[] = [
                'id' => $unionId,
                'partners' => $partners,
                'type' => $type,
                'role' => $this->sanitizeNullableString($union['role'] ?? null, 70),
                'colour' => $this->sanitizeNullableString($union['colour'] ?? null, 20),
                'cssClass' => $this->sanitizeNullableString($union['cssClass'] ?? null, 70),
                'visibility' => $this->sanitizeVisibility($union['visibility'] ?? null),
                'order' => isset($union['order']) && is_numeric($union['order']) ? (int) $union['order'] : (int) $index,
            ];
        }

        $links = [];
        foreach ($graph['links'] as $index => $link) {
            if (! is_array($link)) {
                continue;
            }
            $rawChildId = isset($link['child_id']) && is_string($link['child_id']) ? $link['child_id'] : '';
            $childId = $personIdMap[$rawChildId] ?? $rawChildId;
            if ($childId === '') {
                continue;
            }
            $rawUnionId = isset($link['union_id']) && is_string($link['union_id']) && $link['union_id'] !== ''
                ? $link['union_id']
                : null;
            $unionId = $rawUnionId !== null ? ($unionIdMap[$rawUnionId] ?? $rawUnionId) : null;

            $rawParentId = $unionId === null && isset($link['parent_id']) && is_string($link['parent_id']) && $link['parent_id'] !== ''
                ? $link['parent_id']
                : null;
            $parentId = $rawParentId !== null ? ($personIdMap[$rawParentId] ?? $rawParentId) : null;

            if ($unionId === null && $parentId === null) {
                continue;
            }

            $kind = in_array($link['kind'] ?? null, self::VALID_LINK_KINDS, true)
                ? $link['kind']
                : 'biological';

            $links[] = [
                'id' => $this->ensureUuid($link['id'] ?? null),
                'union_id' => $unionId,
                'parent_id' => $parentId,
                'child_id' => $childId,
                'kind' => $kind,
                'label' => $this->sanitizeNullableString($link['label'] ?? null, 70),
                'colour' => $this->sanitizeNullableString($link['colour'] ?? null, 20),
                'visibility' => $this->sanitizeVisibility($link['visibility'] ?? null),
                'order' => isset($link['order']) && is_numeric($link['order']) ? (int) $link['order'] : (int) $index,
            ];
        }

        return [
            'version' => FamilyTreeMigrator::VERSION,
            'settings' => [
                'direction' => $direction,
                'edgeStyle' => $edgeStyle,
                'compact' => $compact,
            ],
            'people' => $people,
            'unions' => $unions,
            'links' => $links,
        ];
    }

    protected function ensureUuid(mixed $value): string
    {
        if (is_string($value) && Str::isUuid($value)) {
            return $value;
        }

        return (string) Str::uuid();
    }

    protected function sanitizeNullableString(mixed $value, int $maxLength): ?string
    {
        if (! is_string($value)) {
            return null;
        }
        $trimmed = trim($value);
        if ($trimmed === '') {
            return null;
        }

        return mb_substr($trimmed, 0, $maxLength);
    }

    protected function sanitizeVisibility(mixed $value): int
    {
        $int = is_numeric($value) ? (int) $value : Visibility::All->value;

        return in_array($int, [Visibility::All->value, Visibility::Admin->value, Visibility::Member->value], true)
            ? $int
            : Visibility::All->value;
    }

    /**
     * @return array<string, mixed>
     */
    protected function texts(): array
    {
        return [
            'actions' => [
                'edit' => __('crud.edit'),
                'done' => __('crud.save'),
                'clear' => __('families/trees.actions.clear'),
                'reset' => __('families/trees.actions.reset'),
                'save' => __('families/trees.actions.save'),
                'first' => __('families/trees.actions.first'),
                'add_first' => __('families/trees.actions.add_first'),
                'add_parent' => __('families/trees.actions.add_parent'),
                'add_partner' => __('families/trees.actions.add_partner'),
                'add_child' => __('families/trees.actions.add_child'),
                'founder' => __('families/trees.actions.founder'),
                'undo' => __('families/trees.actions.undo'),
                'redo' => __('families/trees.actions.redo'),
                'fit' => __('families/trees.actions.fit'),
                'search' => __('families/trees.actions.search'),
                'minimap' => __('families/trees.actions.minimap'),
                'compact' => __('families/trees.actions.compact'),
                'direction_tb' => __('families/trees.actions.direction_tb'),
                'direction_lr' => __('families/trees.actions.direction_lr'),
                'export' => __('families/trees.actions.export'),
                'export_png' => __('families/trees.actions.export_png'),
                'export_svg' => __('families/trees.actions.export_svg'),
            ],
            'union_types' => [
                'married' => __('families/trees.union_types.married'),
                'partner' => __('families/trees.union_types.partner'),
                'divorced' => __('families/trees.union_types.divorced'),
                'affair' => __('families/trees.union_types.affair'),
                'betrothed' => __('families/trees.union_types.betrothed'),
                'custom' => __('families/trees.union_types.custom'),
            ],
            'link_kinds' => [
                'biological' => __('families/trees.link_kinds.biological'),
                'adopted' => __('families/trees.link_kinds.adopted'),
                'foster' => __('families/trees.link_kinds.foster'),
                'step' => __('families/trees.link_kinds.step'),
                'bastard' => __('families/trees.link_kinds.bastard'),
                'custom' => __('families/trees.link_kinds.custom'),
            ],
            'inspector' => [
                'person_title' => __('families/trees.inspector.person_title'),
                'union_title' => __('families/trees.inspector.union_title'),
                'link_title' => __('families/trees.inspector.link_title'),
                'character' => __('families/trees.inspector.character'),
                'placeholder_name' => __('families/trees.inspector.placeholder_name'),
                'placeholder_subtitle' => __('families/trees.inspector.placeholder_subtitle'),
                'promote_character' => __('families/trees.inspector.promote_character'),
                'promote_success' => __('families/trees.inspector.promote_success'),
                'link_character' => __('families/trees.inspector.link_character'),
                'convert_placeholder' => __('families/trees.inspector.convert_placeholder'),
                'colour' => __('families/trees.inspector.colour'),
                'css' => __('families/trees.inspector.css'),
                'visibility' => __('families/trees.inspector.visibility'),
                'union_type' => __('families/trees.inspector.union_type'),
                'role' => __('families/trees.inspector.role'),
                'kind' => __('families/trees.inspector.kind'),
                'label' => __('families/trees.inspector.label'),
                'delete_person' => __('families/trees.inspector.delete_person'),
                'delete_person_confirm' => __('families/trees.inspector.delete_person_confirm'),
                'delete_union' => __('families/trees.inspector.delete_union'),
                'delete_link' => __('families/trees.inspector.delete_link'),
            ],
            'placeholders' => [
                'badge' => __('families/trees.placeholders.badge'),
                'unknown' => __('families/trees.placeholders.unknown'),
                'create_new' => __('families/trees.placeholders.create_new'),
                'name_placeholder' => __('families/trees.placeholders.name_placeholder'),
                'subtitle_placeholder' => __('families/trees.placeholders.subtitle_placeholder'),
                'search_placeholder' => __('families/trees.placeholders.search_placeholder'),
                'existing_in_tree' => __('families/trees.placeholders.existing_in_tree'),
            ],
            'linked_trees' => [
                'title' => __('families/trees.linked_trees.title'),
                'badge' => __('families/trees.linked_trees.badge'),
                'more' => __('families/trees.linked_trees.more'),
                'jump' => __('families/trees.linked_trees.jump'),
            ],
            'preview' => [
                'label' => __('families/trees.preview.label'),
                'admin' => __('families/trees.preview.admin'),
                'member' => __('families/trees.preview.member'),
                'all' => __('families/trees.preview.all'),
                'banner' => __('families/trees.preview.banner'),
            ],
            'modals' => [
                'clear' => [
                    'confirm' => __('families/trees.modals.clear.confirm'),
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
                    'member' => __('families/trees.modals.entity.add.member'),
                    'visibility' => [
                        'title' => __('crud.fields.visibility'),
                        'all' => __('crud.visibilities.all'),
                        'admins' => __('crud.visibilities.admin'),
                        'members' => __('crud.visibilities.members'),
                    ],
                ],
            ],
            'toasts' => [
                'saved' => __('families/trees.success.saved'),
                'cleared' => __('families/trees.success.cleared'),
                'reseted' => __('families/trees.success.reseted'),
                'exported' => __('families/trees.success.exported'),
            ],
            'unknown' => __('families/trees.unknown'),
        ];
    }
}
