<?php

namespace App\Observers;

use App\Facades\EntityLogger;
use App\Models\Character;
use App\Models\Family;

class FamilyObserver extends MiscObserver
{
    public function crudSaved(Family $family)
    {
        $this->saveMembers($family);
        EntityLogger::model($family)->entity($family->entity)->finish();
    }

    /**
     * Save family members
     */
    protected function saveMembers(Family $family): self
    {
        // Only execute this if a proper post attribute is in the body
        if (!request()->has('sync_family_members')) {
            return $this;
        }

        $ids = request()->post('members', []);

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        foreach ($family->members as $member) {
            // The m_ prefix is to differentiate from existing members to new members
            $existing['m_' . $member->id] = $member;
        }
        $new = [];

        foreach ($ids as $id) {
            if (!empty($existing[$id])) {
                unset($existing[$id]);
            } else {
                /** @var Character|null $character */
                $character = Character::find($id);
                if (!empty($character)) {
                    $new[] = $character->id;

                    $character->families()->attach($family->id);
                    EntityLogger::dirty('members', null);
                }
            }
        }

        // Detach the remaining
        foreach ($existing as $k) {
            $k->families()->detach($family->id);
            EntityLogger::dirty('members', null);
        }
        return $this;
    }

    public function deleting(Family $family)
    {
        /**
         * We need to do this ourselves and not let mysql to it (set null), because the nested wants to delete
         * all descendants when deleting the parent (soft delete)
         */
        foreach ($family->families as $sub) {
            $sub->family_id = null;
            $sub->saveQuietly();
        }
    }
}
