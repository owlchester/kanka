<?php

namespace App\Services\Caches\Traits\User;

use Illuminate\Support\Collection;

trait CampaignCache
{
    /**
     * Get the user campaigns
     */
    public function campaigns(): Collection
    {
        return new Collection(
            $this->primary($this->user->id)->get('campaigns')
        );
    }

    public function follows(): Collection
    {
        return new Collection(
            $this->primary($this->user->id)->get('follows')
        );
    }
}
