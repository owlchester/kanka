<?php

namespace App\Services\Campaign;

use App\Facades\Module;
use App\Models\CampaignPlugin;
use App\Models\EntityTag;
use App\Models\MapMarker;
use App\Models\Relation;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;

class AchievementService
{
    use CampaignAware;

    protected array $primaryTargets = [25, 50, 100, 250, 500];
    //protected $primaryTargets = [2, 5, 10, 25, 40];

    protected array $secondaryTargets = [10, 20, 45, 100, 200];

    protected array $tertiaryTargets = [1, 2, 5, 10, 20];
    //protected $secondaryTargets = [1, 2, 3, 4, 5];

    /**
     */
    public function stats(): array|false
    {
        if (!$this->campaign->superboosted()) {
            return false;
        }

        $cacheKey = 'campaign_' . $this->campaign->id . '_achievements';

        if (Cache::has($cacheKey) && app()->isProduction()) {
            return Cache::get($cacheKey);
        }

        // @phpstan-ignore-next-line
        $characters = $this->campaign->characters()->withInvisible()->count() + $this->random();
        // @phpstan-ignore-next-line
        $locations = $this->campaign->locations()->withInvisible()->count() + $this->random();
        // @phpstan-ignore-next-line
        $creatures = $this->campaign->creatures()->withInvisible()->count() + $this->random();
        // @phpstan-ignore-next-line
        $families = $this->campaign->families()->withInvisible()->count() + $this->random();
        // @phpstan-ignore-next-line
        $dead = $this->campaign->characters()->withInvisible()->where('is_dead', true)->count() + $this->random(10, 30);
        // @phpstan-ignore-next-line
        $calendars = $this->campaign->calendars()->withInvisible()->count() + $this->random(5, 15);
        // @phpstan-ignore-next-line
        $events = $this->campaign->events()->withInvisible()->count() + $this->random();

        $tags = $this->taggedEntities() + $this->random();
        $plugins = $this->plugins()  + $this->random(2, 9);
        $connections = $this->connections() + $this->random(30, 60);
        $markers = $this->markers() + $this->random(30, 60);

        $stats = [
            'characters' => [
                'icon' => config('entities.icons.character'),
                'amount' => $characters,
                'target' => $this->target($characters),
                'level' => $this->level($characters),
                'module' => $this->moduleName('character', 'characters'),
            ],
            'locations' => [
                'icon' => config('entities.icons.location'),
                'amount' => $locations,
                'target' => $this->target($locations),
                'level' => $this->level($locations),
                'module' => $this->moduleName('location', 'locations'),
            ],
            'creatures' => [
                'icon' => config('entities.icons.creature'),
                'amount' => $creatures,
                'target' => $this->target($creatures),
                'level' => $this->level($creatures),
                'module' => $this->moduleName('creature', 'creatures'),
            ],
            'families' => [
                'icon' => config('entities.icons.family'),
                'amount' => $families,
                'target' => $this->target($families, 2),
                'level' => $this->level($families, 2),
                'module' => $this->moduleName('family', 'families'),
            ],
            'calendars' => [
                'icon' => config('entities.icons.calendar'),
                'amount' => $calendars,
                'target' => $this->target($calendars, 3),
                'level' => $this->level($calendars, 3),
                'module' => $this->moduleName('calendar', 'calendars'),
            ],
            'events' => [
                'icon' => config('entities.icons.event'),
                'amount' => $events,
                'target' => $this->target($events, 2),
                'level' => $this->level($events, 2),
                'module' => $this->moduleName('event', 'events'),
            ],
            'dead' => [
                'icon' => 'fa-solid fa-skull',
                'amount' => $dead,
                'target' => $this->target($dead, 2),
                'level' => $this->level($dead, 2),
                'history' => 'dead',
            ],
            'tags' => [
                'icon' => config('entities.icons.tag'),
                'amount' => $tags,
                'target' => $this->target($tags, 1),
                'level' => $this->level($tags, 1),
                'history' => 'tagged',
            ],
            'plugins' => [
                'icon' => 'fa-duotone fa-store',
                'amount' => $plugins,
                'target' => $this->target($plugins, 3),
                'level' => $this->level($plugins, 3),
                'history' => 'plugins',
            ],
            'markers' => [
                'icon' => 'fa-duotone fa-map-location',
                'amount' => $markers,
                'target' => $this->target($markers, 2),
                'level' => $this->level($markers, 2),
                'history' => 'markers',
            ],
            'connections' => [
                'icon' => 'fa-duotone fa-heart',
                'amount' => $connections,
                'target' => $this->target($connections, 2),
                'level' => $this->level($connections, 2),
                'history' => 'connections',
            ],
        ];

        // Calc progress
        foreach ($stats as $key => $stat) {
            $stats[$key]['progress'] = ($stat['amount'] / $stat['target']) * 100;
        }

        // Reorder
        uasort($stats, function ($a, $b) {
            if ($a['level'] == $b['level']) {
                return 0;
            }
            return ($a['level'] < $b['level']) ? 1 : -1;
        });

        Cache::put($cacheKey, $stats, 86400);

        return $stats;
    }

    /**
     */
    public function target(int $amount, int $level = 1): int
    {
        $targets = $level == 1 ? $this->primaryTargets : ($level == 2 ? $this->secondaryTargets : $this->tertiaryTargets);

        $last = 20;
        foreach ($targets as $target) {
            if ($amount < $target) {
                return $target;
            }
            $last = $target;
        }

        return $last;
    }

    /**
     */
    public function level(int $amount, int $level = 1): int
    {
        $targets = $level == 1 ? $this->primaryTargets : ($level == 2 ? $this->secondaryTargets : $this->tertiaryTargets);
        $level = 0;
        foreach ($targets as $target) {
            if ($amount >= $target) {
                $level++;
            }
        }

        return $level;
    }

    /**
     */
    public function title(int $amount, int $level = 1): string
    {
        $targets = $level == 1 ? $this->primaryTargets : ($level == 2 ? $this->secondaryTargets : $this->tertiaryTargets);
        foreach ($targets as $target) {
            if ($amount > $target) {
                $level++;
            }
        }

        return __('campaigns/stats.titles.' . ($level == 1 ? 'primary' : ($level == 2 ? 'secondary' : 'tertiary')) . '.' . $level);
    }

    /**
     */
    public function achievements(): array
    {
        $dead = $this->campaign->characters()->where('is_dead', true)->count();
        $calendars = $this->campaign->calendars()->count();

        $achievements = [
            'dead' => [
                'title' => __('campaigns/stats.achievements.murderer.title'),
                'goal' => __('campaigns/stats.achievements.murderer.goal'),
                'amount' => $dead,
                'target' => 100,
                'icon' => 'ra ra-skull',
            ],
            'calendars' => [
                'title' => __('campaigns/stats.achievements.calendars.title'),
                'goal' => __('campaigns/stats.achievements.calendars.goal'),
                'amount' => $calendars,
                'target' => 3,
                'icon' => 'fa-solid fa-calendar'
            ],
        ];

        // Success rate
        foreach ($achievements as $key => $achievement) {
            $achievements[$key]['score'] = $achievement['amount'] > $achievement['target'] ? 100 : ($achievement['amount'] / $achievement['target']);
        }

        // Reorder by achieved or close
        usort($achievements, function ($a, $b) {
            return strcmp((string) $a['score'], (string) $b['score']);
        });

        return $achievements;
    }

    protected function taggedEntities(): int
    {
        return EntityTag::leftJoin('entities as e', 'e.id', 'entity_tags.entity_id')
            ->where('e.campaign_id', $this->campaign->id)
            ->whereNull('e.deleted_at')
            ->count()
        ;
    }

    protected function plugins(): int
    {
        return CampaignPlugin::where('campaign_id', $this->campaign->id)
            ->count()
        ;
    }

    protected function connections(): int
    {
        return Relation::where('campaign_id', $this->campaign->id)
            ->whereNull('mirror_id')
            ->count()
        ;
    }

    protected function markers(): int
    {
        return MapMarker::leftJoin('maps as m', 'm.id', 'map_markers.map_id')
            ->where('m.campaign_id', $this->campaign->id)
            ->whereNull('m.deleted_at')
            ->count()
        ;
    }

    protected function moduleName(string $singular, string $plural): array
    {
        return [
            'singular' => Module::singular(config('entities.ids.' . $singular), __('entities.' . $singular)),
            'plural' => Module::plural(config('entities.ids.' . $singular), __('entities.' . $plural)),
        ];
    }

    protected function random(int $min = 50, int $max = 400): int
    {
        if (app()->isProduction()) {
            return 0;
        }

        return mt_rand($min, $max);
    }
}
