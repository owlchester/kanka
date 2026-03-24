<?php

namespace App\Services\Entity\Relations;

use App\Models\Entity;
use App\Models\Item;
use App\Models\MiscModel;
use App\Observers\Concerns\HasMany;
use App\Services\Entity\Relations\Concerns\SavesLocations;
use App\Services\Entity\Relations\Concerns\SupportsPatchMode;
use App\Traits\CreatesEntityFromName;

class ItemRelationsService implements RelationsServiceInterface
{
    use CreatesEntityFromName;
    use HasMany;
    use SavesLocations;
    use SupportsPatchMode;

    public function save(MiscModel $model, array $data): void
    {
        /** @var Item $model */
        $this->saveLocations($model, $data);

        if (! array_key_exists('save_creators', $data) && ! array_key_exists('creators', $data)) {
            return;
        }

        $creators = $data['creators'] ?? [];
        $this->saveMany($model, 'creators', $creators, Entity::class, 'itemCreators', 'creator_id');

        // Note: EntityLogger::finish() is intentionally not called here.
    }
}
