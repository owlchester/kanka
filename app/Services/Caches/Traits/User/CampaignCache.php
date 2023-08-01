<?php

namespace App\Services\Caches\Traits\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait CampaignCache
{
    /**
     * Get the user campaigns
     */
    public function campaigns(): Collection
    {
        $key = $this->campaignsKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        /** @var Builder|mixed $query */
        $query = $this->user->campaigns();
        $data = [];

        // order the campaigns array based on the user settings
        switch ($this->user->campaignSwitcherOrderBy) {
            case 'alphabetical':
                $data = $query->orderBy('name', 'asc')->get();
                break;
            case 'r_alphabetical':
                $data = $query->orderBy('name', 'desc')->get();
                break;
            case 'date_joined':
                $data = $query->withPivot('created_at')->orderBy('pivot_created_at', 'asc')->get();
                break;
            case 'r_date_joined':
                $data = $query->withPivot('created_at')->orderBy('pivot_created_at', 'desc')->get();
                break;
            case 'r_date_created':
                $data = $query->orderBy('created_at', 'desc')->get();
                break;
            default:
                $data = $query->get();
                break;
        }

        $this->forever($key, $data);

        return $data;
    }

    public function clearCampaigns(): self
    {
        $key = $this->campaignsKey();
        $this->forget($key);
        return $this;
    }

    protected function campaignsKey(): string
    {
        return 'user_' . $this->user->id . '_campaigns';
    }


    /**
     * Get the user follows
     */
    public function follows(): Collection
    {
        $key = $this->followsKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        /** @var \Illuminate\Database\Query\Builder $query */
        $query = $data = $this->user->following()->public();
        $data = [];

        // order the campaigns array based on the user settings
        switch ($this->user->campaignSwitcherOrderBy) {
            case 'alphabetical':
                $data = $query->orderBy('name', 'asc')->get();
                break;
            case 'r_alphabetical':
                $data = $query->orderBy('name', 'desc')->get();
                break;
            case 'date_joined':
                // @phpstan-ignore-next-line
                $data = $query->withPivot('created_at')->orderBy('pivot_created_at', 'asc')->get();
                break;
            case 'r_date_joined':
                // @phpstan-ignore-next-line
                $data = $query->withPivot('created_at')->orderBy('pivot_created_at', 'desc')->get();
                break;
            case 'date_created':
                $data = $query->orderBy('created_at', 'asc')->get();
                break;
            case 'r_date_created':
                $data = $query->orderBy('created_at', 'desc')->get();
                break;
            default:
                $data = $query->get();
                break;
        }
        $this->forever($key, $data);

        return $data;
    }

    public function clearFollows(): self
    {
        $key = $this->followsKey();
        $this->forget($key);
        return $this;
    }

    protected function followsKey(): string
    {
        return 'user_' . $this->user->id . '_follows';
    }
}
