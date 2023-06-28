<?php

namespace App\Services;

use App\Models\Genre;

class GenreService
{
    /**
     * @return array
     */
    public function getGenres($emptyOption = false)
    {
        $genres = [];
        if ($emptyOption) {
            $genres = [null => ''];
        }
        foreach (Genre::get() as $genre) {
            $genres[$genre->id] = trans('genres.' . $genre->slug);
        }
        return $genres;
    }
}
