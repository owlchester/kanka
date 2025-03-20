<?php

namespace App\Services\Api;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Services\Entity\TagService;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;

class BulkEntityCreatorService
{
    use CampaignAware;
    use EntityTypeAware;
    use UserAware;

    protected MiscModel $new;

    protected Entity $entity;

    protected array $data;

    public function data(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function create(): Entity
    {
        if ($this->entityType->isSpecial()) {
            return $this->createEntity();
        }
        $this->new = $this->entityType->getMiscClass();
        $this->new->fill($this->data);
        $this->new->campaign_id = $this->campaign->id;
        $this->new->save();
        $this->new->crudSaved();
        $this->new->entity->crudSaved();
        $this->entity = $this->new->entity;
        $this->saveTags();

        return $this->new->entity;
    }

    protected function createEntity(): Entity
    {
        $this->entity = new Entity($this->data);
        $this->entity->type_id = $this->entityType->id;
        $this->entity->campaign_id = $this->campaign->id;
        $this->entity->save();
        $this->entity->crudSaved();
        $this->saveTags();

        return $this->entity;
    }

    /**
     * Save the tags
     */
    protected function saveTags(): void
    {
        if (! Arr::has($this->data, 'tags')) {
            return;
        }
        /** @var TagService $tagService */
        $tagService = app()->make(TagService::class);
        $tagService->user($this->user)
            ->entity($this->entity)
            ->sync($this->data['tags']);
    }
}
