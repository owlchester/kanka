<?php

namespace App\Services\Entity;

use App\Models\Bookmark;
use App\Models\CampaignDashboardWidget;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagFormSyncService
{
    public function sync(Bookmark|CampaignDashboardWidget|Post $model, Request $request): void
    {
        if (! $request->has('save_tags')) {
            return;
        }

        $ids = (array) $request->post('tags', []);
        // Diff against visible tags only so hidden tags aren't detached.
        $existing = $model->tags()->pluck('tags.id')->all();
        $added = array_values(array_diff($ids, $existing));
        $removed = array_diff($existing, $ids);

        if ($added !== []) {
            $model->tags()->attach(Tag::findOrFail($added)->modelKeys());
        }
        if ($removed !== []) {
            $model->tags()->detach($removed);
        }
    }
}
