<?php

namespace App\Services\Roadmap;

use App\Models\Feature;
use App\Models\FeatureChampion;
use App\Traits\UserAware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

class FeatureChampionService
{
    use UserAware;

    /**
     * Claim the user's active champion slot for an approved feature, replacing any previous active slot.
     *
     * @throws AuthorizationException
     */
    public function champion(Feature $feature): FeatureChampion
    {
        if (! $this->hasUser() || ! $this->user->can('champion', $feature)) {
            throw new AuthorizationException('User is not authorized to champion this feature.');
        }

        return DB::transaction(function () use ($feature): FeatureChampion {
            FeatureChampion::where('user_id', $this->user->id)
                ->active()
                ->where('feature_id', '!=', $feature->id)
                ->delete();

            return FeatureChampion::firstOrCreate([
                'user_id' => $this->user->id,
                'feature_id' => $feature->id,
            ]);
        });
    }

    /**
     * Remove the user's champion slot from a non-done feature.
     *
     * @throws AuthorizationException
     */
    public function unchampion(Feature $feature): void
    {
        if (! $this->hasUser() || ! $this->user->can('unchampion', $feature)) {
            throw new AuthorizationException('User is not authorized to unchampion this feature.');
        }

        FeatureChampion::where('user_id', $this->user->id)
            ->where('feature_id', $feature->id)
            ->delete();
    }

    /**
     * Release any active (non-Done/non-Rejected) champion slot held by the user.
     */
    public function releaseActive(): void
    {
        if (! $this->hasUser()) {
            return;
        }

        FeatureChampion::where('user_id', $this->user->id)
            ->active()
            ->delete();
    }
}
