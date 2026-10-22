<?php

namespace App\Services\Entity;

use App\Events\Entities\EntityCreationCompleted;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\User;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\UserAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StandardEntityCreationService
{
    use CampaignAware;
    use EntityTypeAware;
    use UserAware;

    public function create(array $data, ?MiscModel $child = null): MiscModel
    {
        if (! $this->entityType->isStandard() || ! $this->entityType->hasEntity()) {
            throw new InvalidArgumentException('Only standard entities can have a child model.');
        }

        $child ??= $this->entityType->getMiscClass();
        if ($child->exists || $child->entityTypeId() !== $this->entityType->id) {
            throw new InvalidArgumentException('The child must be an unsaved model of the requested entity type.');
        }

        return DB::transaction(function () use ($data, $child): MiscModel {
            $entity = new Entity(Arr::only($data, Entity::CREATION_FIELDS));
            $entity->campaign_id = $this->campaign->id;
            $entity->type_id = $this->entityType->id;
            $entity->is_private = $data['is_private'] ?? false;
            if ($this->user instanceof User) {
                $entity->created_by = $this->user->id;
            }
            $entity->setRelation('entityType', $this->entityType);
            $entity->save();

            unset($child->name);
            $child->fill(Arr::except($data, ['name']));
            $child->campaign_id = $this->campaign->id;
            $child->is_private = $entity->is_private;
            $child->setRelation('entity', $entity);
            $child->save();

            $entity->entity_id = $child->id;
            $entity->saveQuietly();
            $child->setRelation('entity', $entity);
            $entity->setRelation('child', $child);
            EntityCreationCompleted::dispatch($entity, $this->user);

            return $child;
        });
    }
}
