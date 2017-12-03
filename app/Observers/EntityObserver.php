<?php

namespace App\Observers;

use App\Models\Entity;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class EntityObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @var LinkerService
     */
    protected $linkerService;

    /**
     * CharacterObserver constructor.
     * @param LinkerService $linkerService
     */
    public function __construct(LinkerService $linkerService)
    {
        $this->linkerService = $linkerService;
    }

    /**
     * @param Entity $entity
     */
    public function saving(Entity $entity)
    {
        $entity->slug = str_slug($entity->name, '');
        $entity->campaign_id = Session::get('campaign_id');

        // Purity text
        $entity->history = $this->purify($entity->history);

        // Parse links
        $entity->history = $this->linkerService->parse($entity->history);

        // Handle image. Let's use a service for this.
        ImageService::handle($entity, $entity->pluralType());

        $nullable = ['location_id'];
        foreach ($nullable as $attr) {
            $entity->setAttribute($attr, (request()->has($attr) ? request()->post($attr) : null));
        }
    }

    /**
     * Delete all relations when deleted
     * @param Entity $entity
     */
    public function deleted(Entity $entity)
    {
       foreach ($entity->relationships as $rel) {
           $rel->delete();
       }

       foreach ($entity->targetRelationships as $rel) {
           $rel->delete();
       }
    }
}
