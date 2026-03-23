<?php

namespace App\Services\Entity\Relations;

use App\Facades\EntityLogger;
use App\Models\Event;
use App\Models\MiscModel;
use App\Services\Entity\Relations\Concerns\SavesLocations;
use App\Services\Entity\Relations\Concerns\SupportsPatchMode;

class EventRelationsService implements RelationsServiceInterface
{
    use SavesLocations;
    use SupportsPatchMode;

    public function save(MiscModel $model, array $data): void
    {
        /** @var Event $model */
        $this->saveLocations($model, $data);
        EntityLogger::model($model)->entity($model->entity)->finish();
    }
}
