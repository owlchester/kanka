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
    public function saveEntity(array $entity): MiscModel
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

    public function class(MiscModel $class): self
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Save the tags
     */
    protected function saveTags(array $ids): void
    {
        /** @var TagService $tagService */
        $tagService = app()->make(TagService::class);
        $tagService->user(auth()->user())
            ->entity($this->new->entity)
            ->sync($ids)
        ;
    }
}
