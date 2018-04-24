<?php

namespace App\Observers;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

abstract class MiscObserver
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
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        $model->slug = str_slug($model->name, '');
        $model->campaign_id = Session::get('campaign_id');


        // If we're from the "move" service, we can skip this part.
        if (defined('MISCELLANY_SKIP_ENTITY_CREATION')) {
            return;
        }

        $attributes = $model->getAttributes();
        if (array_key_exists('history', $attributes)) {
            $model->history = $this->purify($model->history);
            $model->history = $this->linkerService->parse($model->history);
        }
        if (array_key_exists('description', $attributes)) {
            $model->description = $this->purify($model->description);
            $model->description = $this->linkerService->parse($model->description);
        }

        // Handle image. Let's use a service for this.
        ImageService::handle($model, $model->getTable());

        $nullable = ['parent_location_id', 'location_id', 'character_id', 'family_id', 'section_id'];
        foreach ($nullable as $attr) {
            if (array_key_exists($attr, $attributes)) {
                $model->setAttribute($attr, (request()->has($attr) ? request()->post($attr) : null));
            }
        }

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }
    }

    /**
     * @param MiscModel $model
     */
    public function saved(MiscModel $model)
    {
        if (defined('MISCELLANY_SKIP_ENTITY_CREATION')) {
            return;
        }

        // Handle entity
        $entity = $model->entity;
        if (empty($entity)) {
            $entity = new Entity([
                'entity_id' => $model->id,
                'campaign_id' => $model->campaign_id
            ]);
        }
        $entity->is_private = $model->is_private;
        $entity->name = $model->name;
        $entity->type = $model->getEntityType();
        $entity->save();
    }

    /**
     * @param MiscModel $model
     */
    public function deleted(MiscModel $model)
    {
        ImageService::cleanup($model);
    }

    /**
     * @param MiscModel $model
     */
    public function deleting(MiscModel $model)
    {
        // Delete the entity
        if ($model->entity) {
            $model->entity->delete();
        }
    }
}
