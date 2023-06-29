<?php

namespace App\Services\Users;

use App\Jobs\Users\DeleteUser;
use App\User;
use Illuminate\Support\Facades\DB;

class PurgeService
{
    protected int $count = 0;

    protected string $date;

    protected bool $dry = true;

    protected int $limit;

    public function date(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function real(): self
    {
        $this->dry = false;
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
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
            })
            ->whereDate('users.created_at', '<=', $this->date)
            ->where(function ($sub) {
                $sub->where('users.pledge', '')
                    ->orWhereNull('users.pledge');
            })
            ->whereNull('cu.id')
            ->whereNull('users.pm_type')
            ->chunk(500, function ($users) {
                if ($this->count >= $this->limit) {
                    return;
                }
                /** @var User $user */
                foreach ($users as $user) {
                    if ($this->count >= $this->limit) {
                        continue;
                    }
                    $this->count++;
                    if (!$this->dry) {
                        DeleteUser::dispatch($user);
                    }
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
        //$this->reset();

        if ($this->count >= $this->limit) {
            return 0;
        }

        User::distinct()
            ->select('users.id')
            ->leftJoin('campaign_user as cu', 'cu.user_id', 'users.id')
            /*->with([
                'campaigns' => function ($sub) {
                    $sub->select('campaigns.id');
                },
                'campaigns.users' => function ($sub) {
                    $sub->select('users.id');
                }
            ])*/
            ->where(function ($sub) {
                $sub->whereNull('last_login_at')
                    ->orWhereDate('last_login_at', '<=', $this->date);
            })->whereDate('users.created_at', '<=', $this->date)
            ->where(function ($sub) {
                $sub->where('users.pledge', '')
                    ->orWhereNull('users.pledge');
            })
            ->where(DB::raw('(select count(cu2.id) from campaign_user as cu2 where cu2.user_id = users.id)'), '=', 1)
            ->where(DB::raw('(select count(cu3.id) from campaign_user as cu3 where cu3.campaign_id = cu.campaign_id)'), '=', 1)
            ->where(DB::raw('(select count(e.id) from entities as e where e.created_by = users.id and e.deleted_at is null)'), '<', 7)
            ->whereNull('users.pm_type')

            ->chunk(1000, function ($users) {
                if ($this->count >= $this->limit) {
                    return;
                }
                /** @var User $user */
                foreach ($users as $user) {
                    if ($this->count >= $this->limit) {
                        return;
                    }
                    /*if ($user->campaigns->count() > 1) {
                        // We'll want to notify this user, or handle them in another loop
                        continue;
                    }*/
                    $members = 0;
                    $entities = 0;
                    /*foreach ($user->campaigns as $campaign) {
                        $members = $campaign->users->count();
                        //$entities = $campaign->entities()->count();
                    }
                    if ($members > 1) {
                        // More than one member in their only campaign? Take care of them in other loop
                        continue;
                    }*/
                    /*if ($entities > 6) {
                        // A few entities, let's warn them
                        continue;
                    }*/
                    $this->count++;
                    if (!$this->dry) {
                        DeleteUser::dispatch($user);
                    }
                }
            });

        return $this->count;
    }

    protected function reset(): void
    {
        $this->count = 0;
    }
}
