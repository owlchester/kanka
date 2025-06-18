<?php

namespace App\Services\Campaign;

use App\Models\Genre;
use App\Traits\CampaignAware;

class GenreService
{
    use CampaignAware;

    public function save(array $ids): void
    {
        $existing = [];
        /** @var Genre $genre */
        foreach ($this->campaign->genres as $genre) {
            $existing[$genre->id] = $genre->slug;
        }
        $new = [];

        foreach ($ids as $id) {
            if (! empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $genre = Genre::find($id);
                if (! empty($genre)) {
                    $new[] = $genre->id;
                }
            }
        }
        $this->campaign->genres()->attach($new);

        // Detatch the remaining
        if (! empty($existing)) {
            $this->campaign->genres()->detach(array_keys($existing));
        }
    }
}
