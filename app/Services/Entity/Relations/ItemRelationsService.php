<?php

namespace App\Services\Entity\Relations;

use App\Facades\EntityLogger;
use App\Models\Entity;
use App\Models\Item;
use App\Models\MiscModel;
use App\Observers\Concerns\HasMany;
use App\Traits\CreatesEntityFromName;

class ItemRelationsService implements RelationsServiceInterface
{
    use CreatesEntityFromName;
    use HasMany;

    public function save(MiscModel $model, array $data): void
    {
        /** @var Item $model */
        if (! array_key_exists('save_creators', $data) && ! array_key_exists('creators', $data)) {
            return;
        }

        $creators = $data['creators'] ?? [];
        $this->saveMany($model, 'creators', $creators ?? [], Entity::class, 'itemCreators', 'creator_id');

        // Note: EntityLogger::finish() is intentionally not called here.
        // The original ItemObserver::crudSaved() did not call it either.
    }
}
