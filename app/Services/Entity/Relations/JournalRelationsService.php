<?php

namespace App\Services\Entity\Relations;

use App\Facades\EntityLogger;
use App\Models\Journal;
use App\Models\MiscModel;
use App\Services\Entity\Relations\Concerns\SavesLocations;
use App\Services\Entity\Relations\Concerns\SupportsPatchMode;

class JournalRelationsService implements RelationsServiceInterface
{
    use SavesLocations;
    use SupportsPatchMode;

    public function save(MiscModel $model, array $data): void
    {
        /** @var Journal $model */
        $this->saveLocations($model, $data);
        EntityLogger::model($model)->entity($model->entity)->finish();
    }
}
