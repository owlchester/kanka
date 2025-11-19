<?php

namespace App\Services\Dashboards;

use App\Enums\Widget;
use App\Traits\CampaignAware;
use Illuminate\Support\Arr;

class GettingStartedService
{
    use CampaignAware;

    protected array $tasks;

    public function tasks(): array
    {
        $this->tasks = [];

        $this->start()
            ->rename()
            ->character()
            ->location()
            ->invite()
            ->widgets()
        ;

        return $this->tasks;
    }

    protected function start(): self
    {
        $this->track(__('dashboards/widgets/onboarding.tasks.campaign'), true);
        return $this;
    }

    protected function rename(): self
    {
        $completed = true;
        $originalName = Arr::get($this->campaign->settings, 'default-name');
        if (!empty($originalName) && $originalName === $this->campaign->name) {
            $completed = false;
        }
        $this->track(
            __('dashboards/widgets/onboarding.tasks.rename'),
            $completed,
            route('campaigns.edit', [$this->campaign, 'from' => 'onboarding'])
        );

        return $this;
    }

    protected function character(): self
    {
        $completed = $this->campaign
                ->characters()
                ->where('created_at', '>', $this->campaign->created_at)
                ->count() > 0;
        $this->track(
            __('dashboards/widgets/onboarding.tasks.character'),
            $completed,
            route('characters.create', [$this->campaign, 'from' => 'onboarding'])
        );

        return $this;
    }

    protected function location(): self
    {
        $completed = $this->campaign
                ->locations()
                ->where('created_at', '>', $this->campaign->created_at)
                ->count() > 0;
        $this->track(
            __('dashboards/widgets/onboarding.tasks.location'),
            $completed,
            route('locations.create', [$this->campaign, 'from' => 'onboarding'])
        );

        return $this;
    }

    protected function invite(): self
    {
        $completed = $this->campaign->invites()->count() > 0;
        $this->track(
            __('dashboards/widgets/onboarding.tasks.invite'),
            $completed,
            route('campaign_users.index', [$this->campaign, 'from' => 'onboarding'])
        );

        return $this;
    }

    protected function widgets(): self
    {
        $completed = $this->campaign
                ->widgets()
                ->where('created_at', '>', $this->campaign->created_at)
                ->count() > 0;
        $this->track(
            __('dashboards/widgets/onboarding.tasks.widgets'),
            $completed,
            route('dashboard.setup', [$this->campaign, 'from' => 'onboarding'])
        );

        return $this;
    }

    protected function track(string $title, bool $completed, ?string $url = null)
    {
        $this->tasks[] = [
            'title' => $title,
            'completed' => $completed,
            'url' => $url ?? null,
        ];
    }
}
