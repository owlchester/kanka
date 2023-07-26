<?php

namespace App\Services\Api;

use App\Models\CommunityVote;

class VoteService
{
    public function api(): array
    {
        $data = [];

        $votes = CommunityVote::published()
            ->orderBy('visible_at', 'DESC');
        foreach ($votes as $vote) {
            $data[] = [

            ];
        }
        return $data;
    }
}
