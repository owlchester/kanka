<?php

namespace App\Services\Users;

use App\Jobs\Emails\Purge\FirstWarningJob;
use App\Jobs\Emails\Purge\SecondWarningJob;
use App\Jobs\Users\DeleteUser;
use App\Models\JobLog;
use App\Models\User;
use App\Models\UserFlag;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurgeService
{
    protected int $count = 0;

    protected string $date;

    protected array $warnedIds = [];

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
            ->whereNull('users.stripe_id')
            ->chunk(500, function ($users) {
                echo "New chunk\n";
                if ($this->count >= $this->limit) {
                    return false;
                }
                /** @var User $user */
                foreach ($users as $user) {
                    if ($this->count >= $this->limit) {
                        return false;
                    }
                    $this->count++;
                    if (! $this->dry) {
                        DeleteUser::dispatch($user);
                    }
                }
            });

        return $this->count;
    }

    /**
     * Accounts that haven't logged in during two years and only have a campaign with the boilerplate stuff
     */
    public function example(): int
    {
        // $this->reset();

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
            ->whereNull('users.stripe_id')

            ->chunk(2000, function ($users) {
                echo "New chunk\n";
                if ($this->count >= $this->limit) {
                    return false;
                }
                /** @var User $user */
                foreach ($users as $user) {
                    if ($this->count >= $this->limit) {
                        return false;
                    }
                    $this->count++;
                    if (! $this->dry) {
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

    /**
     * Inactive users for > 18 months, warn them of their upcoming deletion
     */
    public function firstWarning(): int
    {
        if ($this->count >= $this->limit) {
            return 0;
        }

        $cutoff = config('purge.users.first.inactivity');
        $this->date = Carbon::now()->subMonths($cutoff);
        User::distinct()
            ->select('users.id')
            ->leftJoin('user_flags as f', function ($sub) {
                return $sub
                    ->on('f.user_id', 'users.id')
                    ->where('f.flag', \App\Enums\UserFlags::firstWarning->value);
            })
            ->where(function ($sub) {
                $sub->whereNull('last_login_at')
                    ->orWhereDate('last_login_at', '<=', $this->date);
            })
            ->whereDate('users.created_at', '<=', $this->date)
            ->where(function ($sub) {
                $sub->where('users.pledge', '')
                    ->orWhereNull('users.pledge');
            })
            ->whereNull('f.id')
            ->whereNull('users.stripe_id')
            ->limit($this->limit)
            ->chunk(1000, function ($users) {
                if ($this->count >= $this->limit) {
                    return false;
                }
                foreach ($users as $user) {
                    if ($this->count >= $this->limit) {
                        return false;
                    }

                    // Add a flag for this user
                    if (! $this->dry) {
                        $flag = new UserFlag;
                        $flag->user_id = $user->id;
                        $flag->flag = \App\Enums\UserFlags::firstWarning;
                        $flag->save();

                        FirstWarningJob::dispatch($user->id);
                    }

                    $this->warnedIds[] = $user->id;
                    $this->count++;
                }
            });

        JobLog::create([
            'name' => 'users:purge',
            'result' => 'First warning: ' . implode(', ', $this->warnedIds),
        ]);
        $this->warnedIds = [];

        return $this->count;
    }

    public function secondWarning(): int
    {
        $this->reset();
        if ($this->count >= $this->limit) {
            return 0;
        }

        // First warning send 23 days ago
        $cutoff = Carbon::now()
            ->subDays(config('purge.users.first.limit'))
            ->addDays(config('purge.users.second.limit'));
        User::distinct()
            ->select('users.id')
            ->leftJoin('user_flags as f', function ($sub) {
                return $sub
                    ->on('f.user_id', 'users.id')
                    ->where('f.flag', \App\Enums\UserFlags::firstWarning->value);
            })
            ->leftJoin('user_flags as f2', function ($sub) {
                return $sub
                    ->on('f2.user_id', 'users.id')
                    ->where('f2.flag', \App\Enums\UserFlags::secondWarning->value);
            })
            ->where(function ($sub) {
                $sub->where('users.pledge', '')
                    ->orWhereNull('users.pledge');
            })
            ->where('f.created_at', '<=', $cutoff)
            ->whereNull('f2.id')
            ->whereNull('users.stripe_id')
            ->limit($this->limit)
            ->chunk(1000, function ($users) {
                if ($this->count >= $this->limit) {
                    return false;
                }
                foreach ($users as $user) {
                    if ($this->count >= $this->limit) {
                        return false;
                    }

                    // Add a flag for this user
                    if (! $this->dry) {
                        $flag = new UserFlag;
                        $flag->user_id = $user->id;
                        $flag->flag = \App\Enums\UserFlags::secondWarning;
                        $flag->save();

                        SecondWarningJob::dispatch($user->id);
                    }

                    $this->warnedIds[] = $user->id;
                    $this->count++;
                }
            });

        JobLog::create([
            'name' => 'users:purge',
            'result' => 'Second warning: ' . implode(', ', $this->warnedIds),
        ]);
        $this->warnedIds = [];

        return $this->count;
    }

    /**
     * Permanently delete users who haven't logged in and contributed in a long time
     */
    public function purge(): int
    {
        $this->reset();
        if ($this->count >= $this->limit) {
            return 0;
        }

        // Warning 2 sent 7 days ago
        $cutoff = Carbon::now()
            ->subDays(config('purge.users.second.limit'));
        User::distinct()
            ->select('users.id')
            ->leftJoin('user_flags as f', function ($sub) {
                return $sub
                    ->on('f.user_id', 'users.id')
                    ->where('f.flag', \App\Enums\UserFlags::secondWarning->value);
            })
            ->where(function ($sub) {
                $sub->where('users.pledge', '')
                    ->orWhereNull('users.pledge');
            })
            ->where('f.created_at', '<=', $cutoff)
            ->whereNull('users.stripe_id')
            ->limit($this->limit)
            ->chunkById(1000, function ($users) {
                if ($this->count >= $this->limit) {
                    return false;
                }
                /** @var User $user */
                foreach ($users as $user) {
                    if ($this->count >= $this->limit) {
                        return false;
                    }

                    // Add a flag for this user
                    if (! $this->dry) {
                        DeleteUser::dispatch($user);
                    }

                    $this->warnedIds[$user->id] = $user->email;
                    $this->count++;
                }
            }, 'users.id', 'id');

        JobLog::create([
            'name' => 'users:purge',
            'result' => 'Purged: ' . collect($this->warnedIds)
                ->map(fn ($v, $k) => "$k:$v")
                ->implode(', '),
        ]);
        $this->warnedIds = [];

        return $this->count;
    }
}
