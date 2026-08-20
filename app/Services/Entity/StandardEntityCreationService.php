<?php

namespace App\Services\Entity;

use App\Events\Entities\EntityCreationCompleted;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\User;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StandardEntityCreationService
{
    use CampaignAware;
    use EntityTypeAware;
    use UserAware;

    public function create(array $data): MiscModel
    {
        if (! $this->entityType->isStandard() || ! $this->entityType->hasEntity()) {
            throw new InvalidArgumentException('Only standard entities can have a child model.');
        }

        return DB::transaction(function () use ($data): MiscModel {
            $entity = new Entity($data);
            $entity->campaign_id = $this->campaign->id;
            $entity->type_id = $this->entityType->id;
            $entity->is_private = $data['is_private'] ?? false;
            if ($this->user instanceof User) {
                $entity->created_by = $this->user->id;
            }
            $entity->setRelation('entityType', $this->entityType);
            $entity->save();

            $child = $this->entityType->getMiscClass();
            $child->fill($data);
            $child->campaign_id = $this->campaign->id;
            $child->name = $entity->name;
            $child->is_private = $entity->is_private;
            $child->setRelation('entity', $entity);
            $child->save();

            $child->setRelation('entity', $entity);
            $entity->setRelation('child', $child);
            EntityCreationCompleted::dispatch($entity, $this->user);

            return $child;
        });
    }
}
