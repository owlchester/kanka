<?php

namespace App\Services\Users;

use App\Enums\UserFlags;
use App\Models\JobLog;
use App\Models\User;
use App\Models\UserFlag;
use Illuminate\Support\Facades\Storage;

class OfferTrialService
{
    protected array $users = [];

    public function run(): int
    {
        $this->find();
        return count($this->users);
    }

    protected function find(): void
    {
        $ids = json_decode(Storage::disk('local')->get('promo.json'), true);

        $users = User::select('users.id')
            ->where('last_login_at', '>', now()->subMonths(3))
            ->leftJoin('user_flags', 'user_flags.user_id', '=', 'users.id')
            ->where(function ($query) {
                $query->whereNull('pledge')->orWhere('pledge', '');
            })
            ->whereNull('user_flags.id')
            ->whereNull('users.booster_count')
            ->whereIn('users.id', $ids)
            ->get();
        foreach ($users as $user) {
            $this->flag($user);
        }
    }

    protected function flag(User $user): void
    {
        $this->users[] = $user->id;

        $flag = new UserFlag;
        $flag->user_id = $user->id;
        $flag->flag = UserFlags::freeTrial;
        $flag->save();
    }

    protected function log(): void
    {
        if (! config('app.log_jobs')) {
            return;
        }

        JobLog::create([
            'name' => 'users:trial',
            'result' => implode(', ', $this->users),
        ]);
    }
}
