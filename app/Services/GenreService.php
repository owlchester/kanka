<?php

namespace App\Services;

use App\Models\Genre;

class GenreService
{
    public function getGenres($emptyOption = false): array
    {
        $genres = [];
        if ($emptyOption) {
            $genres = ['' => __('campaigns.fields.genre')];
        }
        foreach (Genre::get() as $genre) {
            $genres[$genre->id] = trans('genres.' . $genre->slug);
        }

        return $genres;
    }
}
