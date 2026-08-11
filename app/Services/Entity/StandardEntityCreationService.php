<?php

namespace App\Services\Entity;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Observers\ChildEntityObserver;
use App\Observers\EntityLogObserver;
use App\Observers\EntityObserver;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class StandardEntityCreationService
{
    use CampaignAware;
    use EntityTypeAware;

    public function __construct(
        protected EntityObserver $entityObserver,
        protected EntityLogObserver $entityLogObserver,
    ) {}

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
            $entity->isEntityFirstCreation = true;
            $entity->setRelation('entityType', $this->entityType);
            $entity->saveQuietly();

            $child = $this->entityType->getMiscClass();
            $child->fill($data);
            $child->campaign_id = $this->campaign->id;
            $child->name = $entity->name;
            $child->is_private = $entity->is_private;
            ChildEntityObserver::withoutParentCreation(fn () => $child->save());

            $entity->entity_id = $child->id;
            $entity->saveQuietly();

            $child->setRelation('entity', $entity);
            $entity->setRelation('child', $child);

            $this->finalize($entity);

            return $child;
        });
    }

    protected function finalize(Entity $entity): void
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }

        $this->entityObserver->created($entity);
        $this->entityLogObserver->created($entity);
    }
}
