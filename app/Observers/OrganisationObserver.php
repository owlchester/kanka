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
        parent::deleting($organisation);

        // Update sub orgs and members to clean them  up
        foreach ($organisation->organisations as $child) {
            $child->organisation_id = null;
            $child->save();
        }
        foreach ($organisation->members as $child) {
            $child->delete();
        }

        // Refresh the model to make sure we have new foreign keys?
        $organisation->refresh();
    }

    /**
     * Save the sections/categories
     */
    protected function saveMembers(Organisation $organisation)
    {
        //if (request()->has('tags')) {
        // Don't want to run this twice. When creating a tag, it will call this function again.
        // Todo: better options?
        if (defined('MISCELLANY_DYNAMIC_MEMBER_CREATION')) {
            return;
        }
        define('MISCELLANY_DYNAMIC_MEMBER_CREATION', true);
        $ids = request()->post('members', []);

        // Only use tags the user can actually view. This way admins can
        // have tags on entities that the user doesn't know about.
        $existing = [];
        foreach ($organisation->members()->acl()->get() as $member) {
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

        // Detatch the remaining
        foreach ($existing as $k) {
            $k->delete();
        }
    }
}
