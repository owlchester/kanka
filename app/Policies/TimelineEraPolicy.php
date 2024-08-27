<?php

namespace App\Policies;

use App\Models\TimelineEra;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimelineEraPolicy
{
    use HandlesAuthorization;

    public function update(?User $user, TimelineEra $timelineEra)
    {
        return $user && $user->can('update', $timelineEra->timeline);
    }
    public function delete(?User $user, TimelineEra $timelineEra)
    {
        return $user && $user->can('update', $timelineEra->timeline);
    }
}
