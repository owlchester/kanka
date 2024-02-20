<?php

namespace App\Services\Api;

use App\Models\MiscModel;
use App\Traits\CampaignAware;
use App\Services\Entity\TagService;

class BulkEntityCreatorService
{
    use CampaignAware;

    protected MiscModel $class;
    protected MiscModel $new;

    /**
     */
    public function saveEntity(array $entity)
    {
        // Prepare the data
        unset($entity['module']);

        $this->new = new $this->class($entity);
        $this->new->campaign_id = $this->campaign->id;
        $this->new->save();
        $this->new->crudSaved();
        if (isset($entity['tags'])) {
            $this->saveTags($entity['tags']);
        }
        $this->new->entity->crudSaved();

        return $this->new;
    }

    public function class(MiscModel $class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Save the tags
     */
    protected function saveTags(array $ids)
    {
        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        /** @var Tag $tag */
        foreach ($this->new->entity->tags()->with('entity')->has('entity')->get() as $tag) {
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
                $tag = $tagService->fetch($id, $this->new->entity->campaign_id);
                if (!empty($tag)) {
                    $new[] = $tag->id;
                }
            }
        }
        $this->new->entity->tags()->attach($new);

        // Detatch the remaining
        if (!empty($existing)) {
            $this->new->entity->tags()->detach(array_keys($existing));
        }
    }
}
