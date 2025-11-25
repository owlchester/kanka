<?php

namespace App\Services\Users;

use App\Enums\UserFlags;
use App\Models\User;
use App\Models\UserFlag;
use Illuminate\Support\Facades\Storage;

class OfferTrialService
{
    protected array $ids = [];

    public function ids(): array
    {
        return $this->ids;
    }

    public function run(): int
    {
        $this->find();

        return count($this->ids);
    }

    protected function find(): void
    {
        $ids = json_decode(Storage::disk('local')->get('promo.json'), true);
        // $ids = [];

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
        $this->ids[] = $user->id;

        $flag = new UserFlag;
        $flag->user_id = $user->id;
        $flag->flag = UserFlags::freeTrial;
        $flag->save();
    }
}
