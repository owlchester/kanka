<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    /**
     */
    public function transfer(Tag $tag, Tag $newTag): void
    {
        foreach ($tag->entities as $entity) {
            $entity->tags()->detach($tag->id);
            $entity->tags()->attach($newTag->id);
        }
    }

    public function transferPosts(Tag $tag, Tag $newTag): void
    {
        foreach ($tag->posts as $post) {
            $post->tags()->detach($tag->id);
            $post->tags()->attach($newTag->id);
        }
    }
}
