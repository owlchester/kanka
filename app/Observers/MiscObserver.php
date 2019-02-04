<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Jobs\EntityMentionJob;
use App\Models\AttributeTemplate;
use App\Models\CalendarEvent;
use App\Models\Entity;
use App\Models\EntityEvent;
use App\Models\MiscModel;
use App\Services\EntityMappingService;
use App\Services\ImageService;
use Illuminate\Support\Facades\Session;

abstract class MiscObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * Service used to build the map of the entity
     * @var EntityMappingService
     */
    protected $entityMappingService;

    /**
     * CharacterObserver constructor.
     * @param EntityMappingService $entityMappingService
     */
    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        $model->slug = str_slug($model->name, '');
        $model->campaign_id = CampaignLocalization::getCampaign()->id;


        // If we're from the "move" service, we can skip this part.
        // Or if we are deleting, we don't want to re-do the whole set foreign ids to null
        if (defined('MISCELLANY_SKIP_ENTITY_CREATION') ||
            request()->isMethod('delete') === true ||
            $model::$SKIP_SAVING_OBSERVER === true ||
            $model->savingObserver === false) {
            return;
        }

        $attributes = $model->getAttributes();
        if (array_key_exists('entry', $attributes)) {
            $model->entry = $this->purify($model->entry);
        }

        // Handle image. Let's use a service for this.
        ImageService::handle($model, $model->getTable());

        // Default foreign ids that can be set to null. This should probably be in each individual observer instead
        $nullable = [
            'location_id', 'character_id', 'family_id',
            'quest_id', 'calendar_id', 'race_id'
        ];
        foreach ($nullable as $attr) {
            if (array_key_exists($attr, $attributes)) {
                $model->setAttribute($attr, (request()->has($attr) ? request()->post($attr) : null));
            }
        }

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }

        // Calendar trait hook
        if (method_exists($model, 'hasCalendarDateTrait')) {
            if (request()->has(['calendar_id', 'calendar_day', 'calendar_month', 'calendar_year'])) {
                $model->calendar_id = request()->post('calendar_id');
                $model->calendar_year = request()->post('calendar_year');
                $model->calendar_month = request()->post('calendar_month');
                $model->calendar_day = request()->post('calendar_day');
            } else {
                $model->calendar_id = null;
                $model->calendar_year = null;
                $model->calendar_month = null;
                $model->calendar_day = null;
            }
        }
    }

    /**
     * @param MiscModel $model
     */
    public function saved(MiscModel $model)
    {
        if (defined('MISCELLANY_CENTITY_CREATION')) {
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

        // Once saved, refresh the model so that we can call $model->entity
        if ($entity->save()) {
            // Before we refresh the model, check if the model has a calendar date, and
            // if those values are dirty.
            $this->syncEntityEvent($model, $entity);
            $this->syncMentions($model, $entity);
            $model->refresh();
        }

        // Attribute templates
        if (request()->has('template_id') && request()->filled('template_id')) {
            $template = AttributeTemplate::findOrFail(request()->get('template_id'));
            $template->apply($entity);
        }

        // Copy attributes from source?
        if (request()->has('copy_source_attributes') && request()->filled('copy_source_attributes')) {
            $sourceId = request()->post('copy_source_id');
            /** @var Entity $source */
            $source = Entity::findOrFail($sourceId);
            foreach ($source->attributes as $attribute) {
                $attribute->copyTo($model->entity);
            }
        }

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
    public function updated(MiscModel $model)
    {
        // We make an extra write to the db when doing this, but we always want the entity's updated_at to be in
        // sync with the model. For example if we just change the description, which is on the sub entity, we
        // still want the entity to be alerted. This is used for the recently modified dashboard widget.

        // Check if the entity exists, because it won't while moving an entity from one type to another.
        if ($model->entity) {
            $model->entity->touch();
        }
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

    /**
     * Sync the entity event if the model has the calendar date trait
     * @param $model
     */
    protected function syncEntityEvent($model, Entity $entity)
    {
        if (method_exists($model, 'hasCalendarDateTrait')) {
            $previousCalendarId = $model->getOriginal('calendar_id');
            $previousDate = $model->getOriginal('calendar_year') . '-'
                . $model->getOriginal('calendar_month') . '-'
                . $model->getOriginal('calendar_day');

            // Changed?
            if ($model->isDirty(['calendar_id', 'calendar_year', 'calendar_month', 'calendar_day'])) {
                // We already had this event linked
                $event = EntityEvent::where([
                    'calendar_id' => $previousCalendarId,
                    'entity_id' => $entity->id,
                    'date' => $previousDate
                ])->first();
                if ($event) {
                    // We no longer have a calendar attached to this model
                    if (empty($model->calendar_id)) {
                        $event->delete();
                    } else {
                        // Update the existing one
                        $event->calendar_id = $model->calendar_id;
                        $event->date = $model->calendar_year . '-'
                            . $model->calendar_month . '-'
                            . $model->calendar_day;
                        $event->save();
                    }
                } elseif ($model->hasCalendar()) {
                    // We need to create something
                    $event = EntityEvent::create([
                        'calendar_id' => $model->calendar_id,
                        'entity_id' => $entity->id,
                        'date' => $model->calendar_year . '-'
                            . $model->calendar_month . '-'
                            . $model->calendar_day,
                        'length' => request()->post('length', 1),
                        'is_recurring' => request()->post('is_recurring', false),
                    ]);
                }
            }
        }
    }

    /**
     * When saving an entity, we can to update our mentions if they have been changed
     * @param Entity $entity
     */
    protected function syncMentions(MiscModel $model, Entity $entity)
    {
        //$this->entityMappingService->verbose = true;
        // If the entity's entry has changed, we need to re-build it's map.
        if ($model->isDirty('entry')) {
            $this->entityMappingService->silent()->mapEntity($entity);
        }

        // If we changed the name or entry of this object, we need to update the entry of objects mentioning us
        if ($model->isDirty('name') || $model->isDirty('entry')) {
            // If the entity is targeted by mentions, queue a job to update texts
            if ($entity->targetMentions()->count() > 0) {
                EntityMentionJob::dispatch($entity);
            }
        }
    }
}
