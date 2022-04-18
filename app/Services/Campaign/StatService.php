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

    protected $primaryTargets = [25, 50, 100, 250, 500];
    //protected $primaryTargets = [2, 5, 10, 25, 40];

    protected $secondaryTargets = [10, 20, 45, 100, 200];

    protected $tertiaryTargets = [1, 2, 5, 10, 20];
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

    /**
     * @return array|array[]
     */
    public function stats(): array|false
    {
        if (!$this->campaign->superboosted()) {
            return false;
        }

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
                'level' => $this->level($locations),
            ],
            'races' => [
                'icon' => 'ra ra-dragon',
                'amount' => $races,
                'target' => $this->target($races),
                'level' => $this->level($races),
            ],
            'families' => [
                'icon' => 'fa fa-users',
                'amount' => $families,
                'target' => $this->target($families, 2),
                'level' => $this->level($families, 2),
            ],
            'calendars' => [
                'icon' => 'fa fa-calendar',
                'amount' => $calendars,
                'target' => $this->target($calendars, 3),
                'level' => $this->level($calendars, 3),
            ],
            'dead' => [
                'icon' => 'ra ra-skull',
                'amount' => $dead,
                'target' => $this->target($dead, 2),
                'level' => $this->level($dead, 2),
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
     * @param int $amount
     * @param int $level = 1
     * @return int
     */
    public function target(int $amount, int $level = 1): int
    {
        $targets = $level == 1 ? $this->primaryTargets : ($level == 2 ? $this->secondaryTargets : $this->tertiaryTargets);

        $last = 20;
        foreach ($targets as $target) {
            if ($amount <= $target) {
                return $target;
            }
            $last = $target;
        }

        return $last;
    }

    /**
     * @param int $amount
     * @param int $level = 1
     * @return int
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
     * @param int $amount
     * @param int $level = 1
     * @return string
     */
    public function title(int $amount, int $level = 1): string
    {
        $level = 1;
        $targets = $level == 1 ? $this->primaryTargets : ($level == 2 ? $this->secondaryTargets : $this->tertiaryTargets);
        foreach ($targets as $target) {
            if ($amount > $target) {
                $level ++;
            }
        }

        return __('campaigns/stats.titles.' . ($level == 1 ? 'primary' : ($level == 2 ? 'secondary' : 'tertiary')) . '.' . $level);
    }

    /**
     * @return array[]
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
