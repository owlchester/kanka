<?php

namespace App\Services\Entity;

use App\Facades\Identity;
use App\Models\Conversation;
use App\Models\Entity;
use App\Models\EntityLog;
use App\Models\Location;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;

class LogService
{
    use EntityAware;
    use UserAware;

    /** @var mixed MiscModel */
    protected MiscModel $model;

    /**
     * @param MiscModel $model
     * @return $this
     */
    public function model(MiscModel $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Log an update to an entity. Note that this only works on the attributes of the model, so it won't
     * log a creature's locations change.
     * @return void
     */
    public function logUpdate(): void
    {
        $log = new EntityLog();
        $log->entity_id = $this->entity->id;
        $log->created_by = $this->user->id;
        $log->impersonated_by = Identity::getImpersonatorId();
        $log->action = EntityLog::ACTION_UPDATE;
        // No superboosted or premium campaign, no detailed logs
        if (!$this->model->campaign->superboosted()) {
            $log->save();
            return;
        }

        $logs = [];
        $dirty = $this->model->getDirty();
        foreach ($dirty as $attribute => $value) {
            // If the model has this attribute as ignored for logs, skip it
            if (in_array($attribute, $this->model->ignoredLogAttributes())) {
                continue;
            }
            // We log the old value
            $value = $this->model->getOriginal($attribute);
            if (Str::endsWith($attribute, '_id')) {
                // Foreign? Try and get the related model
                $value = $this->getForeignOriginal($this->model, $attribute, $value);
            }

            // If it's not an array, easy work
            if (!is_array($value)) {
                $logs[$attribute] = $value;
                continue;
            }

            // An array (config[, moons[) we need to store it differently
            foreach ($value as $k => $v) {
                $logs[$k] = $v;
            }
        }
        $log->changes = $logs;
        $log->save();
    }

    /**
     * @param MiscModel $model
     * @param string $attribute
     * @param string $original
     * @return string
     */
    protected function getForeignOriginal(MiscModel $model, string $attribute, $original): string
    {
        if (empty($original)) {
            return '';
        }

        try {
            if ($attribute == 'parent_location_id') {
                $originalLocation = Location::where('id', $original)->first();
                if (!empty($originalLocation)) {
                    return (string) $originalLocation->name;
                }
                return '';
            } elseif ($attribute == 'center_marker_id') {
                // Maps can have a "centered marker" which gets tricky
                $originalMarker = \App\Models\MapMarker::where('id', $original)->first();
                if (!empty($originalMarker)) {
                    return (string) $originalMarker->name;
                }
                return '';
            } elseif (in_array($attribute, ['author_id', 'instigator_id'])) {
                // Journals have an author, which can be any entity type. In the future, quests might have this too
                $originalAuthor = Entity::where('id', $original)->first();
                if (!empty($originalAuthor)) {
                    return (string) $originalAuthor->name;
                }
                return '';
            }

            // Silence
            if ($attribute == 'target_id' && $model instanceof Conversation) {
                return __('conversations.targets.' . (
                    $original == Conversation::TARGET_USERS ? 'members' : 'characters'
                ));
            }

            // Let's try based off of the attribute name
            $relationName = Str::before($attribute, '_id');
            $relationName = Str::camel($relationName);

            $relationClass = 'App\Models\\' . ucfirst($relationName);

            /** @var MiscModel $relationModel */
            $relationModel = new $relationClass();
            /** @var MiscModel $result */
            $result = $relationModel->where('id', $original)->firstOrFail();
            return $result->name;
        } catch (\Exception $e) {
            return '';
        }
    }
}
