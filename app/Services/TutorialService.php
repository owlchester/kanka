<?php

namespace App\Services;

use App\Facades\UserCache;
use App\Models\Users\Tutorial;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class TutorialService
{
    use UserAware;

    protected array $tutorials = [
        'campaign_modules',
        'public_permissions',
        'sidebar_reorder',
        'pagination',
        'abilities',
        'attributes',
        'inventory',
        'events',
        'history',
        'map_markers',
        'map_groups',
        'map_layers',
    ];

    /**
     * Reset all the dismissed tutorials for the user
     */
    public function reset(): self
    {
        $this->user
            ->tutorials()
            ->whereIn('code', $this->tutorials)
            ->delete();

        UserCache::user($this->user)->clear();

        return $this;
    }

    /**
     * Save that a user dismissed a tutorial
     */
    public function track(string $code): self
    {
        if (UserCache::dismissedTutorial($code)) {
            return $this;
        }

        $code = Purify::clean($code);

        if (! $this->valid($code) && ! Str::startsWith($code, ['releases_', 'banner_'])) {
            return $this;
        }

        try {
            $tutorial = new Tutorial;
            $tutorial->user_id = $this->user->id;
            $tutorial->code = $code;
            $tutorial->save();

            UserCache::clear();
        } catch (Exception $e) {
            // Someone double-clicked with a slow internet
            return $this;
        }

        return $this;
    }

    protected function valid(string $code): bool
    {
        return in_array($code, $this->tutorials);
    }
}
