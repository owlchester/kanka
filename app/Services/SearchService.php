<?php

namespace App\Services;

use App\Enums\EntityAssetType;
use App\Facades\Avatar;
use App\Facades\Mentions;
use App\Models\Calendar;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Services\Entity\NewService;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;
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

    /** Amount of results (sql limit) */
    protected int $limit = 10;

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
     * Thumb size
     */
    protected int $thumbSize = 64;

    /**
     * Set to true to return new entity options
     */
    protected bool $new = false;

    /**
     * Set to true to return posts
     */
    protected bool $posts = false;

    protected Collection $pages;

    public function __construct(
        protected EntityTypeService $entityTypeService,
        protected NewService $newService
    ) {}

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

    public function thumb(int $size): self
    {
        $this->thumbSize = $size;

        return $this;
    }

    /**
     * The search entity type as requested by the user
     */
    public function type(?int $type = null): self
    {
        if (! empty($type)) {
            $this->onlyTypes = [$type];
        }

        return $this;
    }

    public function new(bool $new = false): self
    {
        $this->new = $new;

        return $this;
    }

    public function posts(bool $posts = true): self
    {
        $this->posts = $posts;

        return $this;
    }

    public function limit(int $limit = 10): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function exclude($types): self
    {
        $this->excludedTypes = is_array($types) ? $types : [$types];

        return $this;
    }

    public function excludeIds($ids): self
    {
        if (empty($ids)) {
            $this->excludeIds = [];

            return $this;
        }
        if (! is_array($ids)) {
            $ids = [$ids];
        }
        $this->excludeIds = $ids;

        return $this;
    }

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
        $availableEntityTypes = $this->entityTypeService
            ->campaign($this->campaign)
            ->available()
            ->pluck('id')
            ->toArray();

        // If a list of types are provided, use those
        if (! empty($this->onlyTypes)) {
            $availableEntityTypes = $this->onlyTypes;
        }
        // If a list of excluded types are provided, remove them from the results
        if (! empty($this->excludedTypes)) {
            $availableEntityTypes = array_diff($availableEntityTypes, $this->excludedTypes);
        }

        $cleanTerm = mb_ltrim(str_replace('_', ' ', $this->term), '=');
        $query = Entity::inTypes($availableEntityTypes)->whereNull('archived_at');
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
                        $join->where('ea.type_id', EntityAssetType::ALIAS->value);
                    })
                    ->where(function ($sub) use ($cleanTerm) {
                        if (Str::startsWith($this->term, '=')) {
                            $sub->where('entities.name', $cleanTerm)
                                ->orWhere('ea.name', $cleanTerm);
                        } else {
                            $sub->where('entities.name', 'like', '%' . $this->term . '%')
                                ->orWhere('ea.name', 'like', '%' . $this->term . '%');
                        }
                    });
            } else {
                if (Str::startsWith($this->term, '=')) {
                    $query->where('name', mb_ltrim($this->term, '='));
                } else {
                    $query->where('name', 'like', '%' . $this->term . '%');
                }
            }

            // Exact name match comes first
            // Only do this when the input string is utf8
            $cleanTerm = preg_replace("/[^a-zA-Z0-9_\-\.\s]/", '', $cleanTerm);
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

        if (! empty($this->excludeIds)) {
            $query->whereNotIn('entities.id', $this->excludeIds);
        }

        $with = ['image', 'entityType'];
        if ($this->posts) {
            $with[] = 'posts';
        }
        $query
            ->with($with)
            ->limit($this->limit);

        $searchResults = $foundEntityIds = [];
        /** @var Entity $model */
        foreach ($query->get() as $model) {
            /** @var ?MiscModel $child */
            // Force having a child for "ghost" entities.
            if ($model->entityType->isStandard()) {
                $child = $model->child;
                if ($child === null || in_array($model->id, $foundEntityIds)) {
                    continue;
                }
            }

            if ($this->v2) {
                $searchResults[] = $this->formatForLookup($model);

                continue;
            }
            $img = '';
            if ($model->hasImage()) {
                $img = '<span class="entity-image cover-background w-8 h-8" style="background-image: url(\''
                    . Avatar::entity($model)->size(192)->thumbnail() . '\');"></span> ';
            }

            $parsedName = str_replace(['&#039;', '&amp;'], ['\'', '&'], $model->name);
            $parsedNameAlias = $parsedName;

            // @phpstan-ignore-next-line
            if ($model->alias_name) {
                $parsedNameAlias = $parsedName . ' - ' . str_replace(['&#039;', '&amp;'], ['\'', '&'], e($model->alias_name));
            }

            if (! $this->full) {
                $searchResults[] = [
                    'id' => $model->id,
                    'text' => $parsedName . ' (' . $model->entityType->name() . ')',
                ];

                continue;
            }

            $searchResults[] = [
                'id' => $model->id,
                'fullname' => $parsedNameAlias,
                'image' => $img,
                'name' => $parsedName,
                'type' => $model->entityType->name(),
                'model_type' => $model->entityType->code,
                'url' => $model->url(),
                'alias_id' => $model->alias_id, // @phpstan-ignore-line
                'advanced_mention' => Mentions::advancedMentionHelper($model->name),
                'advanced_mention_alias' => $model->alias_name ? Mentions::advancedMentionHelper($model->alias_name) : null,
            ];
            $foundEntityIds[] = $model->id;

            // If the result is a map, also add its explore page as a result.
            // @phpstan-ignore-next-line
            if (! $this->posts && ! $this->new && $model->isMap() && $model->child->explorable()) {
                $searchResults[] = [
                    'id' => $model->id,
                    'fullname' => $parsedName,
                    'image' => $img,
                    'name' => $parsedName,
                    'type' => __('maps.actions.explore'),
                    'model_type' => $model->entityType->code,
                    'url' => $model->child->getLink('explore'),
                    'alias_id' => $model->alias_id, // @phpstan-ignore-line
                    'advanced_mention' => Mentions::advancedMentionHelper($model->name),
                    'advanced_mention_alias' => $model->alias_name ? Mentions::advancedMentionHelper($model->alias_name) : null,
                ];
            }

            if (! $this->posts) {
                continue;
            }
            foreach ($model->posts as $post) {
                $postName = str_replace(['&#039;', '&amp;'], ['\'', '&'], $post->name);
                $searchResults[] = [
                    'id' => $post->id,
                    'fullname' => $postName,
                    'image' => null,
                    'name' => $postName,
                    'type' => '',
                    'model_type' => 'post',
                    'url' => route('entities.show', [$this->campaign, $model, '#post-' . $post->id]),
                    'alias_id' => null,
                    'advanced_mention' => Mentions::advancedMentionHelper($post->name),
                    'advanced_mention_alias' => null,
                ];
            }
        }
        if (! $this->new) {
            if ($this->v2) {
                return [
                    'entities' => $searchResults,
                    'pages' => $this->pages(),
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

        // @phpstan-ignore-next-line
        return array_merge(array_values($searchResults), array_values($this->newOptions()));
    }

    /**
     * List of months in the calendars
     */
    public function monthList(): array
    {
        $searchResults = [];

        // Load up the calendars of a campaign to get the month names
        // Todo: this can load any calendar regardless of permission
        $calendars = Calendar::get();
        foreach ($calendars as $calendar) {
            $months = $calendar->months();

            foreach ($months as $month) {
                if ((! empty($this->term) && str_contains($month['name'], $this->term)) || empty($this->term)) {
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
        if (! isset($this->user)) {
            return $options;
        }
        $term = str_replace('_', ' ', $this->term);
        $available = $this->newService->campaign($this->campaign)->user($this->user)->available();

        // Re-order alphabetically and in groups of custom vs default

        $available = $available->sortBy(fn (EntityType $a) => $a->isStandard() . '.' . $a->name());

        foreach ($available as $entityType) {
            $options[] = [
                'new' => true,
                'inject' => '[new:' . $entityType->code . '|' . $term . ']',
                'fullname' => $term,
                'type' => __('crud.titles.new', ['module' => $entityType->name()]),
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
            'image' => Avatar::entity($entity)->fallback()->size($this->thumbSize)->thumbnail(),
            'link' => $entity->url(),
            'type' => $entity->entityType->name(),
            'preview' => route('entities.preview', [$this->campaign, $entity]),
        ];
    }

    protected function pages(): Collection
    {
        $this->pages = new Collection;
        if (empty($this->term)) {
            return $this->pages;
        }
        // Fill data with hardcoded pages and roles
        $this
            ->addCampaignPage('crud.tabs.overview', 'overview')
            ->addCampaignPage('campaigns.show.tabs.achievements', 'campaign.achievements')
            ->addCampaignPage('campaigns.show.tabs.stats', 'campaign.stats');

        if (isset($this->user)) {
            $this
                ->addCampaignPage('campaigns.show.tabs.members', 'campaign_users.index', 'members')
                ->addCampaignPage('campaigns.show.tabs.roles', 'campaign_roles.index', 'roles')
                ->addCampaignPage('campaigns.show.tabs.applications', 'applications.index', 'applications')
                ->addCampaignPage('campaigns.show.tabs.modules', 'campaign.modules')
                ->addCampaignPage('campaigns.show.tabs.recovery', 'recovery', 'update')
                ->addCampaignPage('campaigns.show.tabs.styles', 'campaign_styles.index', 'update')
                ->addCampaignPage('campaigns.show.tabs.export', 'campaign.export')
                ->addCampaignPage('campaigns.show.tabs.import', 'campaign.import')
                ->addCampaignPage('campaigns.show.tabs.webhooks', 'webhooks.index', 'webhooks');
        }
        if (config('marketplace.enabled')) {
            $this->addCampaignPage('campaigns.show.tabs.plugins', 'campaign_plugins.index');
        }

        $this->pages
            ->add(['name' => __('footer.plugins'), 'url' => config('marketplace.url')])
            ->add(['name' => __('footer.documentation'), 'url' => 'https://docs.kanka.io/en/latest/index.html'])
            ->add(['name' => __('front.features.api.link'), 'url' => route('larecipe.index')]);

        if (isset($this->user)) {
            $this->pages
                ->add(['name' => __('settings.menu.premium'), 'url' => route('settings.premium')])
                ->add(['name' => __('Dark mode'), 'url' => route('settings.appearance', ['highlight' => 'dark'])])
                ->add(['name' => __('billing/menu.payment-method'), 'url' => route('billing.payment-method')])
                ->add(['name' => __('billing/menu.history'), 'url' => route('billing.history')]);
        }
        $this->addCampaignRoles();

        return $this->pages->filter(function ($page) {
            return Str::contains(mb_strtolower($page['name']), mb_strtolower($this->term));
        });
    }

    protected function addCampaignPage(string $name, string $route, ?string $perm = null): self
    {
        if (! empty($perm) && (! isset($this->user) || ! $this->user->can($perm, $this->campaign))) {
            return $this;
        }
        $this->pages->add(['name' => __($name), 'url' => route($route, [$this->campaign])]);

        return $this;
    }

    protected function addCampaignRoles(): self
    {
        if (! isset($this->user) || ! $this->user->can('roles', $this->campaign)) {
            return $this;
        }

        foreach ($this->campaign->roles as $role) {
            $this->pages->add(['name' => $role->name . ' (' . __('campaigns.invites.fields.role') . ')', 'url' => route($role->url('show'), [$this->campaign, $role])]);
        }

        return $this;
    }
}
