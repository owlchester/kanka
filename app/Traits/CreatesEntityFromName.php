<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\MiscModel;
use Stevebauman\Purify\Facades\Purify;

trait CreatesEntityFromName
{
    /**
     * Sanitize, authorize, and create a new MiscModel (Location, Character, etc.) from a name string.
     * Returns the new model's ID, or null if creation is not possible.
     *
     * @param  class-string<MiscModel>  $classname
     */
    protected function createModelFromName(string $name, string $classname, EntityType $entityType, Campaign $campaign): ?int
    {
        $name = mb_trim(Purify::clean($name));
        if (empty($name)) {
            return null;
        }

        if (! auth()->user()->can('create', [$entityType, $campaign])) {
            return null;
        }

        /** @var MiscModel $model */
        $model = new $classname([
            'name' => $name,
            'campaign_id' => $campaign->id,
            'is_private' => false,
        ]);
        $model->saveQuietly();
        $model->createEntity();

        return $model->id;
    }

    /**
     * For each value in the array, if it is a non-numeric string, create a new entity with that name.
     * Returns an array of model IDs ready for relationship syncing.
     *
     * @param  array<mixed>  $values
     * @param  class-string<MiscModel>  $classname
     * @return array<int>
     */
    public function resolveNewModels(array $values, string $classname, int $entityTypeId): array
    {
        $campaign = $entityType = null;
        $resolved = [];

        foreach ($values as $value) {
            if (is_numeric($value)) {
                $resolved[] = (int) $value;

                continue;
            }

            if ($campaign === null) {
                $campaign = CampaignLocalization::getCampaign();
                $entityType = $campaign->getEntityTypes()->firstWhere('id', $entityTypeId);
            }

            $id = $this->createModelFromName($value, $classname, $entityType, $campaign);
            if ($id !== null) {
                $resolved[] = $id;
            }
        }

        return $resolved;
    }

    /**
     * Sanitize, authorize, and create a new custom Entity from a name string.
     * Returns the new entity's ID, or null if creation is not possible.
     */
    protected function createEntityFromName(string $name, EntityType $entityType, Campaign $campaign): ?int
    {
        $name = mb_trim(Purify::clean($name));
        if (empty($name)) {
            return null;
        }

        if (! auth()->user()->can('create', [$entityType, $campaign])) {
            return null;
        }

        $entity = new Entity([
            'name' => $name,
            'campaign_id' => $campaign->id,
            'is_private' => false,
        ]);
        $entity->type_id = $entityType->id;
        $entity->save();

        return $entity->id;
    }
}
