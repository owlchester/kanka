<?php

namespace App\Services;

use App\Facades\Avatar;
use App\Facades\Mentions;
use App\Facades\Module;
use App\Models\Calendar;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\MiscModel;
use App\Services\Entity\NewService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;

/**
 * "Old" search that looks in misc models for data
 */
class SearchService
{
    use CampaignAware;
    use UserAware;

    /** The search term */
    protected string $term;

    /** The search entity type */
    protected string $type;

    /** Amount of results (sql limit) */
    protected int $limit = 10;

    protected EntityService $entityService;

    protected NewService $newService;

    /** List of excluded entity types */
    protected array $excludedTypes = [];

    /** List of excluded entity ids */
    protected array $excludeIds = [];

    /** List of the only entity types desired */
    protected array $onlyTypes = [];

    /** If true, adds more info for the nav header lookup */
    protected bool $v2 = false;

    /**
     * Set to true for a full result (rather than id => name)
     */
    protected bool $full = false;

    /**
     * Set to true to return new entity options
     */
    protected bool $new = false;

    public function __construct(EntityService $entityService, NewService $newService)
    {
        $this->entityService = $entityService;
        $this->newService = $newService;
    }

    /**
     * The search term as requested by the user
     */
    public function term(?string $term = null): self
    {
        $this->term = $term;
        return $this;
    }

    /**
     * Sets the service to return data in the "v2" format, used for the header lookup
     */
    public function v2(): self
    {
        $this->v2 = true;
        return $this;
    }

    /**
     * The search entity type as requested by the user
     */
    public function type(?int $type = null): self
    {
        if (!empty($type)) {
            $this->onlyTypes = [$type];
        }
        return $this;
    }

    /**
     */
    public function new(bool $new = false): self
    {
        $this->new = $new;
        return $this;
    }

    /**
     */
    public function limit(int $limit = 10): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     */
    public function exclude($types): self
    {
        $this->excludedTypes = is_array($types) ? $types : [$types];
        return $this;
    }

    /**
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
     */
    public function only(null|array|string $types = null): self
    {
        if (empty($types)) {
            $this->onlyTypes = [];
            return $this;
        }
        $this->onlyTypes = is_array($types) ? $types : [$types];
        return $this;
    }

    /**
     * Set the result as full (live search, mentions)
     */
    public function full(): self
    {
        $this->full = true;
        return $this;
    }

    /**
     * List of entities matching the request
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

            // Exact name match comes first
            // Only do this when the input string is utf8
            $cleanTerm = preg_replace("/[^a-zA-Z0-9_\-\.\s]/", "", $cleanTerm);
            if (mb_strlen($cleanTerm, 'UTF-8') === mb_strlen($cleanTerm)) {
                $escapedTerm = preg_replace('/&/', '\\&', preg_quote($cleanTerm));
                $query->orderByRaw('FIELD(entities.name, ?) DESC', [$cleanTerm]);
                if ($this->campaign->boosted()) {
                    $query->orderByRaw('FIELD(ea.name, ?) DESC', [$cleanTerm]);
                }
                // Name word-start match, so when looking for 'Morley', entities named 'Momorley' appear at the end
                $query->orderByRaw('entities.name RLIKE ? DESC', ["[[:<:]]{$escapedTerm}"]);
                if ($this->campaign->boosted()) {
                    $query->orderByRaw('ea.name RLIKE ? DESC', ["[[:<:]]{$escapedTerm}"]);
                }
                // Partial name match
                $query->orderByRaw('entities.name LIKE ? DESC', ["%{$cleanTerm}%"]);
                if ($this->campaign->boosted()) {
                    $query->orderByRaw('ea.name LIKE ? DESC', ["%{$cleanTerm}%"]);
                }
            }
        }

        if (!empty($this->excludeIds)) {
            $query->whereNotIn('entities.id', $this->excludeIds);
        }

        $query
            ->with('image')
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
            if (!empty($model->image_path)) {
                $img = '<span class="entity-image cover-background" style="background-image: url(\''
                    . Avatar::entity($model)->size(192)->thumbnail() . '\');"></span> ';
            }

            $parsedName = str_replace(['&#039;', '&amp;'], ['\'', '&'], $model->name);
            $parsedNameAlias = $parsedName;

            // @phpstan-ignore-next-line
            if ($model->alias_name) {
                $parsedNameAlias = $parsedName . ' - ' . str_replace(['&#039;', '&amp;'], ['\'', '&'], e($model->alias_name));
            }

            if (!$this->full) {
                $searchResults[] = [
                    'id' => $model->id,
                    'text' => $parsedName . ' (' . Module::singular($model->type_id, $model->entityType()) . ')'
                ];
                continue;
            }

            $searchResults[] = [
                'id' => $model->id,
                'fullname' => $parsedNameAlias,
                'image' => $img,
                'name' => $parsedName,
                'type' => Module::singular($model->type_id, $model->entityType()),
                'model_type' => $model->type(),
                'url' => $model->url(),
                'alias_id' => $model->alias_id, // @phpstan-ignore-line
                'advanced_mention' => Mentions::advancedMentionHelper($model->name),
                'advanced_mention_alias' => $model->alias_name ? Mentions::advancedMentionHelper($model->alias_name) : null,
            ];
            $foundEntityIds[] = $model->id;

            //If the result is a map, also add its explore page as a result.
            // @phpstan-ignore-next-line
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
     */
    protected function newOptions(): array
    {
        $options = [];
        $term = str_replace('_', ' ', $this->term);
        $available = $this->newService->campaign($this->campaign)->available();
        foreach ($available as $type => $class) {
            /** @var MiscModel $misc */
            $misc = new $class();
            $label = __('entities.new.' . $type);
            if (!empty($misc->entityTypeId())) {
                $singular = Module::singular($misc->entityTypeId());
                if ($singular) {
                    $label = __('crud.titles.new', ['module' => $singular]);
                }
            }
            $options[] = [
                'new' => true,
                'inject' => '[new:' . $type . '|' . $term . ']',
                'fullname' => $term,
                'type' => $label,
                'text' => $term,
                'name' => $term,
            ];
        }

        return $options;
    }

    /**
     * Format an entity for the lookup/search/recent dropdown
     * Todo: switch to a trait and share with SearchService
     */
    protected function formatForLookup(Entity $entity): array
    {
        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'is_private' => $entity->is_private,
            'image' => Avatar::entity($entity)->fallback()->size(64)->thumbnail(),
            'link' => $entity->url(),
            'type' => Module::singular($entity->typeId(), __('entities.' . $entity->type())),
            'preview' => route('entities.preview', [$this->campaign, $entity]),
        ];
    }
}
