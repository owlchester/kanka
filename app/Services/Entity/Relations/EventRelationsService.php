<?php

namespace App\Services\Entity\Relations;

use App\Facades\EntityLogger;
use App\Models\Event;
use App\Models\MiscModel;
use App\Services\Entity\Relations\Concerns\SavesLocations;
use App\Services\Entity\Relations\Concerns\SupportsPatchMode;
use App\Services\Events\ParticipantService;

class EventRelationsService implements RelationsServiceInterface
{
    use SavesLocations;
    use SupportsPatchMode;

    public function __construct(private ParticipantService $participants) {}

    public function save(MiscModel $model, array $data): void
    {
        /** @var Event $model */
        $this->saveLocations($model, $data);
        if (isset($data['event_participants'])) {
            $this->participants->save($model, json_decode($data['event_participants'], true, flags: JSON_THROW_ON_ERROR));
        }
        EntityLogger::model($model)->entity($model->entity)->finish();
    }
}
