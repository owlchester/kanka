<?php

namespace App\Services\Dashboards;

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
            ->widgets();

        return $this->tasks;
    }

    protected function start(): self
    {
        $this->track(
            'campaign',
            true
        );

        return $this;
    }

    protected function rename(): self
    {
        $completed = true;
        $originalName = Arr::get($this->campaign->settings, 'default-name');
        if (! empty($originalName) && $originalName === $this->campaign->name) {
            $completed = false;
        }
        $this->track(
            'rename',
            $completed,
            route('campaigns.edit', [$this->campaign, 'from' => 'onboarding'])
        );

        return $this;
    }

    protected function character(): self
    {
        $completed = $this->campaign
            ->characters()
            ->where('created_at', '>', $this->campaign->created_at->addSeconds(10))
            ->count() > 0;
        $this->track(
            'character',
            $completed,
            route('characters.create', [$this->campaign, 'from' => 'onboarding'])
        );

        return $this;
    }

    protected function location(): self
    {
        $completed = $this->campaign
            ->locations()
            ->where('created_at', '>', $this->campaign->created_at->addSeconds(10))
            ->count() > 0;
        $this->track(
            'location',
            $completed,
            route('locations.create', [$this->campaign, 'from' => 'onboarding'])
        );

        return $this;
    }

    protected function invite(): self
    {
        $completed = $this->campaign->invites()->count() > 0;
        $this->track(
            'invite',
            $completed,
            route('campaign_users.index', [$this->campaign, 'from' => 'onboarding'])
        );

        return $this;
    }

    protected function widgets(): self
    {
        $completed = $this->campaign
            ->widgets()
            ->where('created_at', '>', $this->campaign->created_at->addSeconds(10))
            ->count() > 0;
        $this->track(
            'widgets',
            $completed,
            route('dashboard.setup', [$this->campaign, 'from' => 'onboarding'])
        );

        return $this;
    }

    protected function track(string $key, bool $completed, ?string $url = null)
    {
        $this->tasks[] = [
            'name' => __('dashboards/widgets/onboarding.tasks.' . $key . '.name'),
            'helper' => __('dashboards/widgets/onboarding.tasks.' . $key . '.helper'),
            'completed' => $completed,
            'url' => $url ?? null,
        ];
    }
}
