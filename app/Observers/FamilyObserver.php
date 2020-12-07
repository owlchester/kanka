<?php

namespace App\Observers;

use App\Models\Character;
use App\Models\Family;
use App\Models\MiscModel;

class FamilyObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function saved(MiscModel $model)
    {
        parent::saved($model);

        // Save members
        $this->saveMembers($model);
    }

    /**
     * Save the family members
     */
    protected function saveMembers(Family $family)
    {
        // Only execute this if a proper post attribute is in the body
        if (!request()->has('sync_family_members')) {
            return;
        }

        $ids = request()->post('members', []);

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        foreach ($family->members()->get() as $member) {
            // The m_ prefix is to differanciate from existing members to new members
            $existing['m_' . $member->id] = $member;
        }
        $new = [];

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                /** @var Character $character */
                $character = Character::find($id);
                if (!empty($character)) {
                    $new[] = $character->id;

                    $character->family_id = $family->id;
                    $character->saveObserver = false;
                    $character->save();
                }
            }
        }

        // Detach the remaining
        foreach ($existing as $k) {
            $k->family_id = null;
            $k->saveObserver = false;
            $k->save();
        }
    }
}
