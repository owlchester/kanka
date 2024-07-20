<?php

namespace App\Models;

use App\Enums\Widget;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\LastSync;
use App\Models\Concerns\Taggable;
use App\Services\FilterService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class CampaignDashboardWidget
 * @package App\Models
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $entity_id
 * @property int $dashboard_id
 * @property Widget $widget
 * @property array $config
 * @property int $width
 * @property int $position
 * @property Entity $entity
 * @property CampaignDashboard $dashboard
 * @property CampaignDashboardWidgetTag[] $dashboardWidgetTags
 *
 * @method static self|Builder positioned()
 * @method static self|Builder onDashboard(?CampaignDashboard $dashboard = null)
 */
class CampaignDashboardWidget extends Model
{
    use HasCampaign;
    use HasFactory;
    use LastSync;
    use Taggable;

    protected $fillable = [
        'campaign_id',
        'entity_id',
        'widget',
        'config',
        'position',
        'width',
        'dashboard_id',
    ];

    protected $casts = [
        'config' => 'array',
        'widget' => Widget::class,
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function dashboard(): BelongsTo
    {
        return $this->belongsTo(CampaignDashboard::class, 'dashboard_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'campaign_dashboard_widget_tags',
            'widget_id',
            'tag_id'
        )->using(CampaignDashboardWidgetTag::class);
    }

    public function dashboardWidgetTags()
    {
        return $this->hasMany(CampaignDashboardWidgetTag::class, 'widget_id', 'id');
    }

    /**
     * Get the column size
     */
    public function colSize(): int
    {
        if ($this->widget == Widget::Campaign) {
            return 12;
        }
        if (!empty($this->width)) {
            return $this->width;
        }
        return ($this->widget == Widget::Preview || $this->widget == Widget::Random ||
            ($this->widget == Widget::Recent && $this->conf('singular')))
            ? 4 : 6;
    }

    /**
     */
    public function scopePositioned(Builder $query): Builder
    {
        return $query->with([
            'entity', 'entity.image',
            'tags',
            'entity.mentions', 'entity.mentions.target', 'entity.mentions.target.tags:id,name,slug'
        ])
            ->orderBy('position', 'asc');
    }

    /**
     */
    public function scopeOnDashboard(Builder $query, ?CampaignDashboard $dashboard = null): Builder
    {
        if (empty($dashboard)) {
            return $query->whereNull('dashboard_id');
        }

        return $query->where('dashboard_id', $dashboard->id);
    }

    /**
     * @param string $value
     */
    public function conf($value)
    {
        return Arr::get($this->config, $value, null);
    }

    /**
     * Copy a dashboard to another target
     */
    public function copyTo(CampaignDashboard $target)
    {
        $new = $this->replicate(['dashboard_id']);
        $new->dashboard_id = $target->id;
        $new->save();
        foreach ($this->dashboardWidgetTags as $tag) {
            $newTag = $tag->replicate(['widget_id']);
            $newTag->widget_id = $new->id;
            $newTag->save();
        }
        return;
    }

    /**
     */
    public function hasAdvancedOptions(): bool
    {
        return $this->conf('attributes') == 1 ||
            $this->conf('members') == '1' ||
            $this->conf('entity-header') == '1' ||
            $this->conf('relations') == '1'
        ;
    }

    /**
     */
    public function showAttributes(): bool
    {
        if ($this->conf('attributes') != '1') {
            return false;
        }
        if (!in_array($this->widget, [Widget::Preview, Widget::Recent, Widget::Random])) {
            return false;
        }
        if ($this->widget == Widget::Recent) {
            return true;
        }

        return !empty($this->entity);
    }

    /**
     */
    public function showRelations(): bool
    {
        if ($this->conf('relations') != '1') {
            return false;
        }
        if (!in_array($this->widget, [Widget::Preview, Widget::Recent, Widget::Random])) {
            return false;
        }
        if ($this->widget == Widget::Recent) {
            return true;
        }

        return !empty($this->entity);
    }

    /*
     * Show members of families and organisations
     * @param Entity|null $entity
     * @return bool
     */
    public function showMembers(?Entity $entity = null): bool
    {
        if ($this->conf('members') !== '1') {
            return false;
        }
        if (!in_array($this->widget, [Widget::Preview, Widget::Recent, Widget::Random])) {
            return false;
        }
        $types = [
            config('entities.ids.family'),
            config('entities.ids.organisation'),
        ];

        // Preview, check the linked entity
        $entity = !empty($entity) ? $entity : $this->entity;
        return $entity !== null && in_array($entity->typeId(), $types);
    }

    /**
     * Get the entities of a widget
     */
    public function entities(int $page = 1)
    {
        $base = new Entity();

        $excludedTypes = [];

        if ($this->filterUnmentioned()) {
            $base = $base->unmentioned()
                ->whereNotIn($base->getTable() . '.type_id', $excludedTypes)
            ;
        } elseif ($this->filterMentionless()) {
            $base = $base->mentionless()
                ->whereNotIn($base->getTable() . '.type_id', $excludedTypes)
            ;
        }

        // Ordering
        $order = Arr::get($this->config, 'order', null);
        if (empty($order)) {
            $base = $base->recentlyModified();
        } elseif ($order == 'oldest') {
            $base = $base->oldestModified();
        } else {
            list($field, $order) = explode('_', $order);
            $base = $base->orderBy($field, $order);
        }

        // If an entity type is provided, we can combine that with filters. We need to get the list of the misc
        // ids first to pass on to the entity query.
        $entityType = $this->conf('entity');
        if (!empty($entityType) && !empty($this->config['filters'])) {
            $className = 'App\Models\\' . Str::studly($entityType);
            /** @var Character|mixed $model */
            $model = new $className();

            /** @var FilterService $filterService */
            $filterService = app()->make('App\Services\FilterService');
            $filterService
                ->session(false)
                ->options($this->filterOptions())
                ->model($model)
                ->make($entityType);

            $models = $model
                ->select($model->getTable() . '.id')
                ->filter($filterService->filters())
                ->get();

            $entityIds = $models->pluck('id');

            // Add the filter to the base query
            $base = $base->whereIn('entities.entity_id', $entityIds);
        }

        $entityTypeID = (int) config('entities.ids.' . $entityType);
        return $base
            ->inTags($this->tags->pluck('id')->toArray())
            ->inTypes($entityTypeID)
            ->with(['image:campaign_id,id,ext', 'mentions', 'mentions.target', 'mentions.target.tags'])
            ->paginate(10, ['*'], 'page', $page)
        ;
    }

    /**
     * Get a random entity
     * Todo: refactor this code with the code from the quick link?
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function randomEntity()
    {
        $entityType = $this->conf('entity');
        $entityTypeID = null;
        if (!empty($entityType)) {
            $entityTypeID = (int) config('entities.ids.' . $entityType);
        }

        $base = new Entity();

        if (!empty($entityType) && !empty($this->config['filters'])) {
            $className = 'App\Models\\' . Str::studly($entityType);
            /** @var MiscModel $model */
            $model = new $className();

            /** @var FilterService $filterService */
            $filterService = app()->make('App\Services\FilterService');
            $filterService
                ->session(false)
                ->options($this->filterOptions())
                ->model($model)
                ->make($entityType);

            // @phpstan-ignore-next-line
            $models = $model
                ->select($model->getTable() . '.id')
                ->filter($filterService->filters())
                ->get();

            $entityIds = $models->pluck('id');

            // Add the filter to the base query
            $base = $base->whereIn('entities.entity_id', $entityIds);
        }

        return $base
            ->inTags($this->tags->pluck('id')->toArray())
            ->whereNotIn('type_id', [config('entities.ids.attribute_template'), config('entities.ids.conversation'), config('entities.ids.tag')])
            ->whereNotIn('entities.id', \App\Facades\Dashboard::excluding())
            ->inTypes($entityTypeID)
            ->with(['image'])
            ->inRandomOrder()
            ->first();
    }

    /**
     * Get the widget filters
     */
    public function filterOptions(): array
    {
        if (empty($this->config['filters'])) {
            return [];
        }

        try {
            $filters = [];
            $segments = explode('&', $this->config['filters']);
            foreach ($segments as $segment) {
                $params = explode('=', $segment);
                $name = $params[0];
                if (Str::endsWith($name, '[]')) {
                    $filters[mb_substr($name, 0, -2)][] = $params[1];
                    continue;
                }
                $filters[$params[0]] = $params[1];
            }

            return $filters;
        } catch (Exception $e) {
            //Log::error('Widget error:' . $e->getMessage());
            return [];
        }
    }

    /**
     * A way to set the entity, typically for the random widget
     * @return $this
     */
    public function setEntity(Entity $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     */
    public function widgetIcon(): string
    {
        if ($this->widget === Widget::Recent) {
            return 'fa-solid fa-list';
        } elseif ($this->widget === Widget::Header) {
            return 'fa-solid fa-heading';
        } elseif ($this->widget === Widget::Preview) {
            return 'fa-solid fa-align-justify';
        } elseif ($this->widget === Widget::Calendar) {
            return 'ra ra-moon-sun';
        } elseif ($this->widget === Widget::Random) {
            return 'fa-solid fa-dice-d20';
        } elseif ($this->widget === Widget::Campaign) {
            return 'fa-solid fa-th-list';
        }
        return 'fa-solid fa-question-circle';
    }

    /**
     */
    public function customClass(Campaign $campaign): string
    {
        if (!$campaign->boosted()) {
            return '';
        }
        if (empty($this->conf('class'))) {
            return '';
        }

        return (string) $this->conf('class');
    }

    /**
     */
    public function customSize(): string
    {
        if (empty($this->conf('size'))) {
            return 'h3';
        }

        return (string) $this->conf('size');
    }

    /**
     */
    protected function filterUnmentioned(): bool
    {
        return Arr::get($this->config, 'adv_filter') === 'unmentioned';
    }

    /**
     */
    protected function filterMentionless(): bool
    {
        return Arr::get($this->config, 'adv_filter') === 'mentionless';
    }

    /**
     * Determine if a widget is visible. This is a simple check on the linked entity, if there is one.
     */
    public function visible(): bool
    {
        // Not linked to an entity, easy
        if (empty($this->entity_id)) {
            return true;
        }
        // Linked but no entity or no child? Permission issue or deleted entity
        return !empty($this->entity);
    }
}
