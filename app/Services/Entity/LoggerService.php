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
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoggerService
{
    use CampaignAware;
    use EntityAware;
    use UserAware;

    protected array $logged = [];

    /** Track fields that are dirty for the current entity */
    protected array $changes = [];

    /** Track entities that were created in the current execution */
    protected array $created = [];

    protected EntityLog $log;

    protected MiscModel $model;

    /** Track if the model is dirty on a relationship property like many to many (character races, tags) */
    protected bool $dirty = false;

    public function model(MiscModel $model): self
    {
        $this->model = $model;
        $this->modelDirty();

        return $this;
    }

    public function finish(): void
    {
        // If the model isn't dirty, or was created right now, there is no need for logging
        if (! $this->dirty || $this->created) {
            return;
        }

        $this->update();
        $this->entity->touchQuietly();
        $this->model->touchQuietly();
    }

    public function created(): bool
    {
        return in_array($this->entity->id, $this->created);
    }

    public function create(): void
    {
        if ($this->logged()) {
            return;
        }

        $this->log(EntityLog::ACTION_CREATE);
        $this->log->save();

        $this->created[] = $this->entity->id;
    }

    public function dirty(string $key, mixed $values): self
    {
        $this->changes[$key] = $values;
        $this->dirty = true;

        return $this;
    }

    public function isDirty(): bool
    {
        return $this->dirty;
    }

    public function update(): void
    {
        if ($this->logged()) {
            $this->tail(EntityLog::ACTION_UPDATE);
        } else {
            $this->log(EntityLog::ACTION_UPDATE);
        }

        $this->buildDirty();
        if (empty($this->changes)) {
            return;
        }
        if (! empty($this->log->changes)) {
            $changes = $this->log->changes + $this->changes;
            $this->log->changes = $changes;
        } else {
            $this->log->changes = $this->changes;
        }

        // Only save for superboosted and premium campaigns
        if (isset($this->campaign) && ! $this->campaign->superboosted()) {
            $this->log->changes = null;
        }
        $this->log->save();

        $this->dirty = false;
        $this->changes = [];
    }

    public function delete(): void
    {
        $this->log(EntityLog::ACTION_DELETE);
        $this->log->save();
    }

    public function restore(): void
    {
        $this->log(EntityLog::ACTION_RESTORE);
        $this->log->save();
    }

    protected function log(int $action)
    {
        $this->log = new EntityLog;
        $this->log->parent_id = $this->entity->id;
        $this->log->parent_type = Entity::class;
        $this->log->created_by = isset($this->user) ? $this->user->id : null;
        $this->log->action = $action;
        $this->log->impersonated_by = Identity::getImpersonatorId();
    }

    protected function tail(int $action)
    {
        /** @var EntityLog $log */
        $log = $this->entity->logs()->where('action', $action)->latest()->first();
        if ($log) {
            $this->log = $log;
        }
    }

    protected function logged(): bool
    {
        if (in_array($this->entity->id, $this->logged)) {
            return true;
        }
        $this->logged[] = $this->entity->id;

        return false;
    }

    protected function buildDirty(): self
    {
        $this->entityDirty();

        return $this;
    }

    protected function modelDirty(): void
    {
        if (! isset($this->model)) {
            return;
        }
        $ignoredAttributes = [
            'slug',
            'campaign_id',
            'updated_at',
            'deleted_at',
        ];
        foreach ($this->model->getDirty() as $attribute => $value) {
            // If the model has this attribute as ignored for logs, skip it
            if (in_array($attribute, $ignoredAttributes)) {
                continue;
            }
            // We log the old value
            $value = $this->model->getOriginal($attribute);
            if (Str::endsWith($attribute, '_id')) {
                // Foreign? Try and get the related model
                $value = $this->getForeignOriginal($attribute, $value);
            }

            // If it's not an array, easy work
            if (! is_array($value)) {
                $this->changes[$attribute] = $value;

                continue;
            }

            // An array (config[, moons[) we need to store it differently
            foreach ($value as $k => $v) {
                $this->changes[$k] = $v;
            }
        }
    }

    protected function entityDirty(): void
    {
        if (! isset($this->entity)) {
            return;
        }
        $dirty = $this->entity->getDirty();
        $ignoredAttributes = ['created_at', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at', 'type_id', 'words'];
        foreach ($dirty as $attribute => $value) {
            // If the model has this attribute as ignored for logs, skip it
            if (in_array($attribute, $ignoredAttributes)) {
                continue;
            }
            // We log the old value
            $value = $this->entity->getOriginal($attribute);
            if (Str::endsWith($attribute, '_id')) {
                // Foreign? Try and get the related model
                $value = $this->getForeignOriginal($attribute, $value);
            }

            // If it's not an array, easy work
            if (! is_array($value)) {
                $this->changes[$attribute] = $value;

                continue;
            }

            // An array (config[, moons[) we need to store it differently
            foreach ($value as $k => $v) {
                $this->changes[$k] = $v;
            }
        }
    }

    protected function getForeignOriginal(string $attribute, mixed $original): string
    {
        if (empty($original)) {
            return '';
        }

        try {
            if ($attribute == 'location_id') {
                $originalLocation = Location::where('id', $original)->first();
                if (! empty($originalLocation)) {
                    return (string) $originalLocation->name;
                }

                return '';
            } elseif ($attribute == 'center_marker_id') {
                // Maps can have a "centered marker" which gets tricky
                $originalMarker = \App\Models\MapMarker::where('id', $original)->first();
                if (! empty($originalMarker)) {
                    return (string) $originalMarker->name;
                }

                return '';
            } elseif (in_array($attribute, ['author_id', 'instigator_id', 'creator_id'])) {
                // Journals have an author, which can be any entity type. In the future, quests might have this too
                $originalAuthor = Entity::where('id', $original)->first();
                if (! empty($originalAuthor)) {
                    return (string) $originalAuthor->name;
                }

                return '';
            } elseif ($attribute === 'parent_id' && ! isset($this->model)) {
                $originalAuthor = Entity::where('id', $original)->first();
                if (! empty($originalAuthor)) {
                    return (string) $originalAuthor->name;
                }
            }

            // Silence
            if ($attribute == 'target_id' && $this->model instanceof Conversation) {
                return __('conversations.targets.' . (
                    $original == Conversation::TARGET_USERS ? 'members' : 'characters'
                ));
            }

            // Let's try based off of the attribute name
            $relationName = Str::before($attribute, '_id');
            $relationName = Str::camel($relationName);

            $relationClass = 'App\Models\\' . ucfirst($relationName);

            /** @var MiscModel $relationModel */
            $relationModel = new $relationClass;
            /** @var MiscModel $result */
            $result = $relationModel->where('id', $original)->firstOrFail();

            return $result->name;
        } catch (Exception $e) {
            Log::error('Issue with Logger', ['e' => $e->getMessage()]);

            return '';
        }
    }
}
