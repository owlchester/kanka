<?php

namespace App\Services\Caches\Traits\Campaign;

use Illuminate\Support\Collection;

trait MemberCache
{
    public function members(): Collection
    {
        return new Collection($this->primary($this->activeCampaign()->id)->get('members'));
    }

    protected function formatMembers(): array
    {
        $data = [];
        foreach ($this->activeCampaign()->members as $member) {
            $data[] = [
                'id' => $member->user_id,
            ];
        }

        return $data;
    }
}
