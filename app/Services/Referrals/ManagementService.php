<?php

namespace App\Services\Referrals;

use App\Models\Referral;
use App\Models\User;
use App\Traits\UserAware;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ManagementService
{
    use UserAware;

    protected Collection $referrals;

    public function referral(): Referral
    {
        $code = Referral::where('user_id', $this->user->id)->firstOrNew();
        if (! $code->exists()) {
            return $this->createReferral();
        }

        return $code;
    }

    public function users(): int
    {
        if (app()->hasDebugModeEnabled()) {
            return mt_rand(1, 50);
        }

        return $this->referrals()->count();
    }

    protected function referrals(): Collection
    {
        if (isset($this->referrals)) {
            return $this->referrals;
        }

        return $this->referrals = User::select(['id', 'pledge'])->where('referred_by', $this->user->id)->get();
    }

    public function subscribers(): int
    {
        if (app()->hasDebugModeEnabled()) {
            return mt_rand(0, 10);
        }

        return $this->referrals()->whereNotNull('pledge')->count();
    }

    public function badge(): string
    {
        $count = $this->users();
        if ($count < 5) {
            return 'I';
        } elseif ($count < 12) {
            return 'II';
        }

        return 'III';
    }

    protected function createReferral(): Referral
    {
        while (true) {
            try {
                return Referral::create([
                    'user_id' => $this->user->id,
                    'code' => $this->generateCode(),
                ]);
            } catch (QueryException $e) {
                if ($e->getCode() !== '23000') {
                    throw $e;
                }
                // If it's a collision, retry
            }
        }
    }

    protected function generateCode(int $length = 8): string
    {
        return Str::random($length);
    }
}
