<?php

namespace App\Observers;

use App\Models\Webhook;
use App\Models\Tag;
use App\Services\Entity\TagService;

class WebhookObserver
{
    use PurifiableTrait;

    public function saved(Webhook $webhook)
    {
        $this->saveTags($webhook);
    }

    /**
     * Save the sections/categories
     */
    protected function saveTags(Webhook $webhook)
    {
        // HTML forms will have 'save-tags', while the api will have a tag array if they want to make changes.
        if (!request()->has('tags') && !request()->has('save-tags')) {
            return;
        }
        $ids = request()->post('tags', []);
        if (!is_array($ids)) { // People sent weird stuff through the API
            $ids = [];
        }

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        /** @var Tag $tag */
        foreach ($webhook->tags()->with('entity')->has('entity')->get() as $tag) {
            if ($tag->entity) {
                $existing[$tag->id] = $tag->name;
            }
        }
        $new = [];

        /** @var TagService $tagService */
        $tagService = app()->make(TagService::class);
        $tagService->user(auth()->user());

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $tag = $tagService->fetch($id, $webhook->campaign_id);
                if (!empty($tag)) {
                    $new[] = $tag->id;
                }
            }
        }
        $webhook->tags()->attach($new);

        // Detatch the remaining
        if (!empty($existing)) {
            $webhook->tags()->detach(array_keys($existing));
        }
    }
}
