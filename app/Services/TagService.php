<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    /**
     * @return void
     */
    public function transfer(Tag $tag, Tag $newTag): void
    {
        foreach ($tag->entities as $entity) {
            $entity->tags()->detach($tag->id);
            $entity->tags()->attach($newTag->id);
        }
    }
}
