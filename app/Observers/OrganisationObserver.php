<?php

namespace App\Observers;

use App\Models\Character;
use App\Models\MiscModel;
use App\Models\Organisation;
use App\Models\OrganisationMember;

class OrganisationObserver extends MiscObserver
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
     * @param Organisation $organisation
     */
    public function deleting(MiscModel $organisation)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the nested wants to delete
         * all descendants when deleting the parent (soft delete)
         */
        foreach ($organisation->organisations as $child) {
            $child->organisation_id = null;
            $child->save();
        }

        // We need to refresh our foreign relations to avoid deleting our children nodes again
        $this->cleanupTree($organisation, 'organisation_id');
    }

    /**
     * Save the sections/categories
     */
    protected function saveMembers(Organisation $organisation)
    {
        // Only execute this if a proper post attribute is in the body
        if (!request()->has('sync_org_members')) {
            return;
        }

        $ids = request()->post('members', []);

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        foreach ($organisation->members()->has('character')->get() as $member) {
            // The m_ prefix is to differanciate from existing members to new members
            $existing['m_' . $member->id] = $member;
        }
        $new = [];

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                $character = Character::find($id);
                if (!empty($character)) {
                    $new[] = $character->id;

                    $member = OrganisationMember::create([
                        'organisation_id' => $organisation->id,
                        'character_id' => $character->id
                    ]);
                }
            }
        }

        // Detach the remaining
        foreach ($existing as $k) {
            $k->delete();
        }
    }
}
