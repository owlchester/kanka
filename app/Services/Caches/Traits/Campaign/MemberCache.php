<?php

namespace App\Services\Caches\Traits\Campaign;

use Illuminate\Support\Collection;

trait MemberCache
{
    public function members(): Collection|null
    {
        $key = $this->membersKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->members;

        $this->forever($key, $data);
        return $data;
    }

    public function clearMembers(): self
    {
        $this->forget(
            $this->membersKey()
        );
        return $this;
    }

    protected function membersKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_members';
    }
}
