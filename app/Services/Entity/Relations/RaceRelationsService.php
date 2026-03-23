<?php

namespace App\Services\Entity\Relations;

use App\Facades\EntityLogger;
use App\Models\MiscModel;
use App\Models\Race;
use App\Services\Entity\Relations\Concerns\SavesLocations;

class RaceRelationsService implements RelationsServiceInterface
{
    use SavesLocations;

    public function save(MiscModel $model, array $data): void
    {
        /** @var Race $model */
        $this->saveLocations($model, $data);
        EntityLogger::model($model)->entity($model->entity)->finish();
    }
}
