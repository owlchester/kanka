<?php

namespace App\Services\Entity\Relations;

use App\Facades\EntityLogger;
use App\Models\Character;
use App\Models\Family;
use App\Models\MiscModel;
use App\Services\Entity\Relations\Concerns\SavesLocations;
use App\Services\Entity\Relations\Concerns\SupportsPatchMode;

class FamilyRelationsService implements RelationsServiceInterface
{
    use SavesLocations;
    use SupportsPatchMode;

    public function save(MiscModel $model, array $data): void
    {
        /** @var Family $model */
        $this->saveLocations($model, $data);
        $this->saveMembers($model, $data);
        EntityLogger::model($model)->entity($model->entity)->finish();
    }

    /** Save family members from submitted data */
    protected function saveMembers(Family $family, array $data): void
    {
        if (! array_key_exists('sync_family_members', $data)) {
            return;
        }

        $ids = (array) ($data['members'] ?? []);

        $existing = [];
        foreach ($family->members as $member) {
            $existing['m_' . $member->id] = $member;
        }

        foreach ($ids as $id) {
            if (! empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $character = Character::find($id);
                if (! empty($character)) {
                    $character->families()->attach($family->id);
                    EntityLogger::dirty('members', null);
                }
            }
        }

        foreach ($existing as $k) {
            $k->families()->detach($family->id);
            EntityLogger::dirty('members', null);
        }
    }
}
