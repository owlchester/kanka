<?php

namespace App\Services\Caches\Traits\Campaign;

use Illuminate\Support\Collection;

trait MemberCache
{
    public function members(): Collection
    {
        return new Collection($this->primary($this->campaign->id)->get('members'));
    }

    protected function formatMembers(): array
    {
        $data = [];
        foreach ($this->campaign->members as $member) {
            $data[] = [
                'id' => $member->user_id,
            ];
        }

        return $data;
    }
}
