<?php

namespace App\Services\Api;

use App\Models\CommunityVote;

class VoteService
{
    public function api(): array
    {
        $data = [];

        $votes = CommunityVote::published()
            ->orderBy('visible_at', 'DESC')
            ->paginate(15);
        foreach ($votes as $vote) {
            $data[] = [

            ];
        }

        return $data;
    }
}
