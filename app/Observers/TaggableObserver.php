<?php

namespace App\Observers;

use App\Models\Bookmark;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;

class TaggableObserver
{
    public function saved(Model $model)
    {
        $this->saveTags($model);
    }

    /**
     * @return void
     */
    protected function saveTags(Model $model)
    {
        /** @var Bookmark $model */
        if (! request()->has('save_tags')) {
            return;
        }

        // Only save tags if we are in a form.
        $ids = (array) request()->post('tags', []);

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        foreach ($model->tags as $tag) {
            $existing[$tag->id] = $tag->name;
        }
        $new = [];

        foreach ($ids as $id) {
            if (! empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                /** @var Tag $tag */
                $tag = Tag::findOrFail($id);
                $new[] = $tag->id;
            }
        }
        $model->tags()->attach($new);

        // Detach the remaining
        if (! empty($existing)) {
            $model->tags()->detach(array_keys($existing));
        }
    }
}
