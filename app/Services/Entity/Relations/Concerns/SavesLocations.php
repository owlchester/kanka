<?php

namespace App\Services\Entity\Relations\Concerns;

use App\Models\MiscModel;
use App\Services\Entity\Relations\LocationRelationsService;

trait SavesLocations
{
    protected function saveLocations(MiscModel $model, array $data): void
    {
        app(LocationRelationsService::class)->save($model, $data);
    }
}
