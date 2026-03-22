<?php

namespace App\Services\Entity\Relations;

use App\Facades\EntityLogger;
use App\Models\Character;
use App\Models\MiscModel;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use App\Services\Entity\Relations\Concerns\SavesLocations;

class OrganisationRelationsService implements RelationsServiceInterface
{
    use SavesLocations;

    public function save(MiscModel $model, array $data): void
    {
        /** @var Organisation $model */
        $this->saveLocations($model, $data);
        $this->saveMembers($model, $data);
        EntityLogger::model($model)->entity($model->entity)->finish();
    }

    /** Save organisation members from submitted data */
    protected function saveMembers(Organisation $organisation, array $data): void
    {
        if (! array_key_exists('sync_org_members', $data)) {
            return;
        }

        $ids = (array) ($data['members'] ?? []);

        $existing = [];
        foreach ($organisation->members()->has('character')->get() as $member) {
            $existing['m_' . $member->id] = $member;
        }

        foreach ($ids as $id) {
            if (! empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $character = Character::find($id);
                if (! empty($character)) {
                    OrganisationMember::create([
                        'organisation_id' => $organisation->id,
                        'character_id' => $character->id,
                    ]);
                    EntityLogger::dirty('members', null);
                }
            }
        }

        foreach ($existing as $k) {
            $k->delete();
            EntityLogger::dirty('members', null);
        }
    }
}
