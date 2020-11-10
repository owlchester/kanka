<?php


namespace App\Services\Campaign;


use App\Models\Campaign;
use Illuminate\Support\Facades\Cache;

class StatService
{
    /**
     * @var Campaign
     */
    protected $campaign;

    protected $primaryTargets = [50, 200, 500, 1000, 3000];

    protected $secondaryTargets = [10, 25, 50, 100, 500];
    //protected $secondaryTargets = [1, 2, 3, 4, 5];
    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function stats(): array
    {
        $cacheKey = 'campaign_' . $this->campaign->id . '_achievements';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $characters = $this->campaign->characters()->count();
        $locations = $this->campaign->locations()->count();
        $races = $this->campaign->races()->count();
        $families = $this->campaign->families()->count();

        $dead = $this->campaign->characters()->where('is_dead', true)->count();
        $calendars = $this->campaign->calendars()->count();

        $stats = [
            'characters' => [
                'icon' => 'fa fa-user',
                'amount' => $characters,
                'target' => $this->target($characters),
                'level' => $this->level($characters),
            ],
            'locations' => [
                'icon' => 'ra ra-tower',
                'amount' => $locations,
                'target' => $this->target($locations),
                'level' => $this->level($characters),
            ],
            'races' => [
                'icon' => 'ra ra-dragon',
                'amount' => $races,
                'target' => $this->target($races),
                'level' => $this->level($characters),
            ],
            'families' => [
                'icon' => 'fa fa-users',
                'amount' => $families,
                'target' => $this->target($families),
                'level' => $this->level($families),
            ],
            'calendars' => [
                'icon' => 'fa fa-calendar',
                'amount' => $calendars,
                'target' => $this->target($calendars, false),
                'level' => $this->level($calendars, false),
            ],
            'dead' => [
                'icon' => 'ra ra-skull',
                'amount' => $dead,
                'target' => $this->target($dead, false),
                'level' => $this->level($dead, false),
            ],
        ];

        // Calc progress
        foreach ($stats as $key => $stat) {
            $stats[$key]['progress'] = ($stat['amount'] / $stat['target']) * 100;
        }

        // Reorder
        uasort($stats, function ($a, $b) {
            return $a['level'] < $b['level'];
        });

        Cache::put($cacheKey, $stats, 86400);

        return $stats;
    }

    /**
     * @param int $amount
     * @param bool $primary
     * @return int
     */
    public function target(int $amount, bool $primary = true): int
    {
        $targets = $primary ? $this->primaryTargets : $this->secondaryTargets;

        foreach ($targets as $target) {
            if ($amount < $target) {
                return $target;
            }
        }

        return 20;
    }

    /**
     * @param int $amount
     * @param bool $primary
     * @return int
     */
    public function level(int $amount, bool $primary = true): int
    {
        $targets = $primary ? $this->primaryTargets : $this->secondaryTargets;

        $level = 0;
        foreach ($targets as $target) {
            if ($amount >= $target) {
                $level++;
            }
        }

        return $level;
    }

    /**
     * @param int $amount
     * @param bool $primary
     * @return string
     */
    public function title(int $amount, bool $primary = true): string
    {
        $level = 1;
        $targets = $primary ? $this->primaryTargets : $this->secondaryTargets;
        foreach ($targets as $target) {
            if ($amount > $target) {
                $level ++;
            }
        }

        return __('campaigns/stats.titles.' . ($primary ? 'primary' : 'secondary') . '.' . $level);
    }

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
                'icon' => 'fa fa-calendar'
            ],
        ];

        // Success rate
        foreach($achievements as $key => $achievement) {
            $achievements[$key]['score'] = $achievement['amount'] > $achievement['target'] ? 100 : ($achievement['amount'] / $achievement['target']);
        }

        // Reorder by achieved or close
        usort($achievements, function ($a, $b) {
            return $a['score'] < $b['score'];
        });

        return $achievements;
    }
}
