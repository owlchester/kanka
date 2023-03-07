<?php

namespace App\Services;

use App\Facades\Mentions;
use App\Models\Calendar;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SearchService
{
    use CampaignAware;
    use UserAware;

    /** @var string The search term */
    protected string $term;

    /** @var string The search entity type */
    protected string $type;

    /** @var int Amount of results (sql limit) */
    protected int $limit = 10;

    /** @var EntityService */
    protected EntityService $entityService;

    /** @var array List of excluded entity types */
    protected array $excludedTypes = [];

    /** @var array List of excluded entity ids */
    protected array $excludeIds = [];

    /** @var array List of the only entity types desired */
    protected array $onlyTypes = [];

    /** @var bool If true, adds more info for the nav header lookup */
    protected bool $v2 = false;

    /**
     * Set to true for a full result (rather than id => name)
     * @var bool
     */
    protected bool $full = false;

    /**
     * Set to true to return new entity options
     * @var bool
     */
    protected bool $new = false;

    /**
     * SearchService constructor.
     * @param EntityService $entityService
     */
    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    /**
     * The search term as requested by the user
     * @param string|null $term
     * @return $this
     */
    public function term(string $term = null): self
    {
        $this->term = $term;
        return $this;
    }

    /**
     * Sets the service to return data in the "v2" format, used for the header lookup
     * @return $this
     */
    public function v2(): self
    {
        $this->v2 = true;
        return $this;
    }

    /**
     * The search entity type as requested by the user
     * @param int|null $type
     * @return $this
     */
    public function type(int $type = null): self
    {
        if (!empty($type)) {
            $this->onlyTypes = [$type];
        }
        return $this;
    }

    /**
     * @param bool $new = false
     * @return $this
     */
    public function new(bool $new = false): self
    {
        $this->new = $new;
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit = 10): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param array|string|null $types
     * @return $this
     */
    public function exclude($types): self
    {
        $this->excludedTypes = is_array($types) ? $types : [$types];
        return $this;
    }

    /**
     * @param array|string $ids
     * @return $this
     */
    public function excludeIds($ids): self
    {
        if (empty($ids)) {
            $this->excludeIds = [];
            return $this;
        }
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        $this->excludeIds = $ids;
        return $this;
    }

    /**
     * @param array|string $types
     * @return $this
     */
    public function only($types): self
    {
        $this->onlyTypes = is_array($types) ? $types : [$types];
        return $this;
    }

    /**
     * Set the result as full (live search, mentions)
     * @return $this
     */
    public function full(): self
    {
        $this->full = true;
        return $this;
    }

    /**
     * List of entities matching the request
     * @return array
     */
    public function find()
    {
        // Figure out what kind of entities we want.
        $availableEntityTypes = $this->entityService
            ->campaign($this->campaign)
            ->getEnabledEntitiesID();

        // If a list of types are provided, use those
        if (!empty($this->onlyTypes)) {
            $availableEntityTypes = $this->onlyTypes;
        }
        // If a list of excluded types are provided, remove them from the results
        if (!empty($this->excludedTypes)) {
            $availableEntityTypes = array_diff($availableEntityTypes, $this->excludedTypes);
        }

        $cleanTerm = ltrim(str_replace('_', ' ', $this->term), '=');
        $query = Entity::inTypes($availableEntityTypes);
        if (empty($this->term)) {
            $query->orderBy('updated_at', 'DESC');
        } else {
            if ($this->campaign->boosted()) {
                $query
                    ->select(['entities.*', 'ea.id as alias_id', 'ea.name as alias_name'])
                    ->distinct()
                    ->leftJoin('entity_assets as ea', function ($join) use ($cleanTerm) {
                        $join->on('ea.entity_id', '=', 'entities.id');
                        if (Str::startsWith($this->term, '=')) {
                            $join->where('ea.name', $cleanTerm);
                        } else {
                            $join->where('ea.name', 'like', '%' . $this->term . '%');
                        }
                        $join->where('ea.type_id', EntityAsset::TYPE_ALIAS);
                    })
                    ->where(function ($sub) use ($cleanTerm) {
                        if (Str::startsWith($this->term, '=')) {
                            $sub->where('entities.name', $cleanTerm)
                                ->orWhere('ea.name', $cleanTerm)
                            ;
                        } else {
                            $sub->where('entities.name', 'like', '%' . $this->term . '%')
                                ->orWhere('ea.name', 'like', '%' . $this->term . '%')
                            ;
                        }
                    });
            } else {
                if (Str::startsWith($this->term, '=')) {
                    $query->where('name', ltrim($this->term, '='));
                } else {
                    $query->where('name', 'like', '%' . $this->term . '%');
                }
            }
        }

        if (!empty($this->excludeIds)) {
            $query->whereNotIn('entities.id', $this->excludeIds);
        }

        $query
            ->limit($this->limit);

        $searchResults = $foundEntityIds = [];
        /** @var Entity $model */
        foreach ($query->get() as $model) {
            /** @var MiscModel|null $child */
            // Force having a child for "ghost" entities.
            $child = $model->child;
            if ($child === null || in_array($model->id, $foundEntityIds)) {
                continue;
            }

            if ($this->v2) {
                $searchResults[] = $this->formatForLookup($model);
                continue;
            }
            $img = '';
            if (!empty($child->image)) {
                $img = '<span class="entity-image" style="background-image: url(\''
                    . $child->thumbnail() . '\');"></span> ';
            }

            $parsedName = str_replace('&#039;', '\'', e($model->name));
            $parsedNameAlias = $parsedName;

            if ($model->alias_name) {
                $parsedNameAlias = $parsedName . ' - ' . str_replace('&#039;', '\'', e($model->alias_name));
            }

            if (!$this->full) {
                $searchResults[] = [
                    'id' => $model->id,
                    'text' => $parsedName . ' (' . __('entities.' . $model->type()) . ')'
                ];
                continue;
            }

            $searchResults[] = [
                'id' => $model->id,
                'fullname' => $parsedNameAlias,
                'image' => $img,
                'name' => $parsedName,
                'type' => __('entities.' . $model->type()),
                'model_type' => $model->type(),
                'url' => $model->url(),
                'alias_id' => $model->alias_id, // @phpstan-ignore-line
                'advanced_mention' => Mentions::advancedMentionHelper($model->name),
                'advanced_mention_alias' => $model->alias_name ? Mentions::advancedMentionHelper($model->alias_name) : null,
            ];
            $foundEntityIds[] = $model->id;

            //If the result is a map, also add its explore page as a result.
            if (!request()->new && $model->isMap() && $model->child->explorable()) {
                $searchResults[] = [
                    'id' => $model->id,
                    'fullname' => $parsedName,
                    'image' => $img,
                    'name' => $parsedName,
                    'type' => __('maps.actions.explore'),
                    'model_type' => $model->type(),
                    'url' => $model->url('explore'),
                    'alias_id' => $model->alias_id, // @phpstan-ignore-line
                    'advanced_mention' => Mentions::advancedMentionHelper($model->name),
                    'advanced_mention_alias' => $model->alias_name ? Mentions::advancedMentionHelper($model->alias_name) : null,
                ];
            }
        }
        if (!$this->new) {
            if ($this->v2) {
                return [
                    'entities' => $searchResults,
                    'texts' => [
                        'results' => __('Results'),
                        'empty_results' => __('No results'),
                    ]
                ];
            }
            return $searchResults;
        } elseif (empty($searchResults)) {
            return $this->newOptions();
        }

        $lowerCleanTerm = mb_strtolower($cleanTerm);
        foreach ($searchResults as $result) {
            if (mb_strtolower($result['name']) == $lowerCleanTerm) {
                return $searchResults;
            }
        }

        return array_merge(array_values($searchResults), array_values($this->newOptions()));
    }

    /**
     * List of months in the calendars
     * @return array
     */
    public function monthList(): array
    {
        $searchResults = [];

        // Load up the calendars of a campaign to get the month names
        $calendars = Calendar::get();
        foreach ($calendars as $calendar) {
            $months = $calendar->months();

            foreach ($months as $month) {
                if ((!empty($this->term) && str_contains($month['name'], $this->term)) || empty($this->term)) {
                    $searchResults[] = [
                        'fullname' => $month['name'],
                        'name' => $month['name'] . ' (' . $calendar->name . ')',
                    ];
                }
            }
        }

        return $searchResults;
    }

    /**
     * List of elements that can be created on the fly
     * @return array
     */
    protected function newOptions(): array
    {
        $options = [];
        $term = str_replace('_', ' ', $this->term);
        foreach ($this->entityService->newEntityTypes() as $type => $class) {
            $options[] = [
                'new' => true,
                'inject' => '[new:' . $type . '|' . $term . ']',
                'fullname' => $term,
                'type' => __('entities.new.' . $type),
                'text' => $term,
                'name' => $term,
            ];
        }

        return $options;
    }

    public function recent(): array
    {
        $recentIds = $this->recentEntityIds();
        if (empty($recentIds)) {
            return [];
        }

        $orderedIds = implode(',', $recentIds);
        $entities = Entity::whereIn('id', $recentIds)
            ->orderByRaw("FIELD(id, $orderedIds)")
            ->get();
        $recent = [];

        /** @var Entity $entity */
        foreach ($entities as $entity) {
            $recent[] = $this->formatForLookup($entity);
        }

        return $recent;
    }

    /**
     * Format an entity for the lookup/search/recent dropdown
     * @param Entity $entity
     * @return array
     */
    protected function formatForLookup(Entity $entity): array
    {
        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'is_private' => $entity->is_private,
            'image' => $entity->avatarSize(64)->avatar(),
            'link' => $entity->url(),
            'type' => __('entities.' . $entity->type()),
            'preview' => route('entities.preview', $entity)
        ];
    }

    public function logView(Entity $entity): void
    {
        $recents = $original = $this->recentEntityIds();
        $recents = array_diff($recents, [$entity->id]);
        $recents = [$entity->id, ...$recents];

        // Limit the array to five
        $recents = array_splice($recents, 0, 5);

        if ($recents == $original) {
            return;
        }
        $key = $this->recentEntityCacheKey();
        cache()->put($key, $recents, 7 * 86400);
    }

    protected function recentEntityIds(): array
    {
        $key = $this->recentEntityCacheKey();
        if (!cache()->has($key)) {
            return [];
        }
        return (array) cache()->get($key);
    }

    protected function recentEntityCacheKey(): string
    {
        return 'recent_c' . $this->campaign->id . '_u' . $this->user->id;
    }
}
