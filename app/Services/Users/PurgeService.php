<?php

namespace App\Services\Users;

use App\Jobs\Users\DeleteUser;
use App\User;

class PurgeService
{
    protected int $count = 0;

    protected string $date;

    public function date(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Accounts that haven't logged in during two years and have no campaign whatsoever
     * @return int
     */
    public function empty(): int
    {
        $this->reset();
        User::select('users.*')
            ->leftJoin('campaign_user as cu', 'cu.user_id', 'users.id')
            ->where(function ($sub) {
                $sub->whereNull('last_login_at')
                    ->orWhereDate('last_login_at', '<=', $this->date);
            })->whereDate('users.created_at', '<=', $this->date)
            ->where('users.pledge', '')
            ->whereNull('cu.id')
            ->chunk(500, function ($users) {
                /** @var User $user */
                foreach ($users as $user) {
                    $this->count++;
                    DeleteUser::dispatch($user);
                }
            });
        return $this->count;
    }

    /**
     * Accounts that haven't logged in during two years and only have a campaign with the boilerplate stuff
     * @return int
     */
    public function example(): int
    {
        $this->reset();

        User::distinct()
            ->with([
                'campaigns' => function ($sub) {
                    $sub->select('campaigns.id');
                },
                'campaigns.users' => function ($sub) {
                    $sub->select('users.id');
                }
            ])
            ->where(function ($sub) {
                $sub->whereNull('last_login_at')
                    ->orWhereDate('last_login_at', '<=', $this->date);
            })->whereDate('users.created_at', '<=', $this->date)
            ->where('users.pledge', '')
            ->has('campaigns')

            ->chunk(500, function ($users) {
                /** @var User $user */
                if ($this->count >= 500) {
                    return;
                }
                foreach ($users as $user) {
                    if ($user->campaigns->count() > 1) {
                        // We'll want to notify this user, or handle them in another loop
                        continue;
                    }
                    $members = 0;
                    $entities = 0;
                    foreach ($user->campaigns as $campaign) {
                        $members = $campaign->users->count();
                        $entities = $campaign->entities()->count();
                    }
                    if ($members > 1) {
                        // More than one member in their only campaign? Take care of them in other loop
                        continue;
                    }
                    if ($entities > 6) {
                        // A few entities, let's warn them
                        continue;
                    }
                    $this->count++;
                    DeleteUser::dispatch($user);
                }
            });

        return $this->count;
    }

    protected function reset(): void
    {
        $this->count = 0;
    }
}
