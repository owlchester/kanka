<?php


namespace App\Services\Campaign;


use App\Models\Campaign;

class StatService
{
    /**
     * @var Campaign
     */
    protected $campaign;

    protected $primaryTargets = [50, 200, 500, 1000, 3000];

    protected $secondaryTargets = [20, 100, 200, 500, 1000];
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
        $characters = $this->campaign->characters()->count();
        $locations = $this->campaign->locations()->count();
        $races = $this->campaign->races()->count();

        return [
            'characters' => [
                'title' => $this->title($characters),
                'amount' => $characters,
                'target' => $this->target($characters),
            ],
            'locations' => [
                'title' => $this->title($locations),
                'amount' => $locations,
                'target' => $this->target($locations),
            ],
            'races' => [
                'title' => $this->title($races),
                'amount' => $races,
                'target' => $this->target($races),
            ],

            'achievements' => $this->achievements(),

        ];
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
