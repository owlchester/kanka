<?php

namespace App\Services\Subscribers;

use App\Models\Pledge;
use App\Models\Role;
use App\User;
use Illuminate\Support\Arr;

class HallOfFameService
{
    /**
     * Get a list of subscribers for the hall of fame
     * @return array list of subscribers by pledge
     */
    public function subscribers(): array
    {
        $cacheKey = 'about_subscribers';
        if (cache()->has($cacheKey)) {
            //return cache()->get($cacheKey);
        }
        $subscribers = [
            'elemental' => [],
            'wyvern' => [],
            'owlbear' =>  [],
            'goblin' => [],
            'kobold' => []
        ];

        /** @var ?Role $role */
        $role = Role::where(['name' => Pledge::ROLE])->first();

        // No subscriber role? Local instance or not properly set up. Let's just avoid throwing an error.
        if ($role === null) {
            return $subscribers;
        }

        $users = User::select(['pledge', 'name', 'settings'])
            ->leftJoin('user_roles as ur', function ($join) use ($role) {
                $join->on('ur.user_id', '=', 'users.id')
                    ->where('ur.role_id', $role->id);
            })
            ->whereNotNull('ur.role_id')
            ->orderBy('users.name', 'ASC')
            ->get();
        /** @var User $user */
        foreach ($users as $user) {
            if (empty($user->pledge) || $user->pledge === Pledge::KOBOLD) {
                continue;
            }
            if (Arr::get($user, 'settings.hide_subscription', false)) {
                continue;
            }
            $subscribers[mb_strtolower($user->pledge)][] = $user->name;
        }

        // Cache for a day
        cache()->set($cacheKey, $subscribers, 3600 * 24);

        return $subscribers;
    }
}
