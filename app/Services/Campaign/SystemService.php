<?php

namespace App\Services\Campaign;

use App\Models\GameSystem;
use App\Traits\CampaignAware;

class SystemService
{
    use CampaignAware;

    public function save(array $ids): void
    {
        $existing = [];
        foreach ($this->campaign->systems as $system) {
            $existing[$system->id] = $system->name;
        }
        $new = [];

        foreach ($ids as $id) {
            if (! empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $genre = GameSystem::find($id);
                if (! empty($genre)) {
                    $new[] = $genre->id;
                }
            }
        }
        $this->campaign->systems()->attach($new);

        // Detatch the remaining
        if (! empty($existing)) {
            $this->campaign->systems()->detach(array_keys($existing));
        }
    }
}
