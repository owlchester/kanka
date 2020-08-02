<?php

namespace App\Observers;

use App\Facades\CharacterCache;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\MiscModel;
use App\Models\OrganisationMember;
use Illuminate\Support\Collection;

class CharacterObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function crudSaved(MiscModel $model)
    {
        parent::crudSaved($model);
        $this->saveTraits($model, 'personality');
        $this->saveTraits($model, 'appearance');
        $this->saveOrganisations($model);
    }

    /**
     * @param MiscModel $model
     */
    protected function saveTraits(MiscModel $character, $trait = 'personality')
    {
        // Users who can edit the character but can't access personality traits shouldn't be allowed to
        // change those traitrs.
        if ($trait == 'personality' && !auth()->user()->can('personality', $character)) {
            return;
        }

        $existing = [];
        foreach ($character->characterTraits()->{$trait}()->get() as $pers) {
            $existing[$pers->id] = $pers;
        }

        $traitCount = $traitOrder = 0;
        $traitNames = request()->post($trait . '_name', []);
        $traitEntry = request()->post($trait . '_entry', []);

        foreach ($traitNames as $id => $name) {
            if (empty($name)) {
                continue;
            }

            if (!empty($existing[$id])) {
                $model = $existing[$id];
                unset($existing[$id]);
            } else {
                $model = new CharacterTrait();
                $model->character_id = $character->id;
                $model->section = $trait;
            }
            $model->name = $name;
            $model->entry = $traitEntry[$id];
            $model->default_order = $traitOrder;
            $model->save();
            $traitCount++;
            $traitOrder++;
        }

        foreach ($existing as $id => $model) {
            $model->delete();
        }
    }

    /**
     * Save a character's organisations
     * @param MiscModel $character
     * @throws \Exception
     */
    protected function saveOrganisations(MiscModel $character): void
    {
        // If the organisations array isn't provided, skip this feature. The crud interface will always provide one,
        // and the api calls will provide one if necessary.
        if (!request()->has('organisations')) {
            return;
        }

        /** @var OrganisationMember $org */
        $existing = [];
        foreach ($character->organisations()->has('organisation')->get() as $org) {
            $existing[$org->id] = $org;
        }

        $orgCount = 0;
        $organisations = request()->post('organisations', []);
        $roles = new Collection(request()->post('organisation_roles', []));
        $privates = new Collection(request()->post('organisation_privates', []));

        // Prepare roles and permissions that a new (have no id) to properly map them with new organisations
        $newRoles = new Collection();
        foreach ($roles as $id => $role) {
            if (empty($id)) {
                $newRoles->push($role);
            }
        }

        $newPrivates = new Collection();
        foreach ($privates as $id => $private) {
            if (empty($id)) {
                $newPrivates->push($private);
            }
        }

        foreach ($organisations as $key => $id) {
            if (empty($id)) {
                continue;
            }

            if (!empty($existing[$id])) {
                $model = $existing[$id];
                unset($existing[$id]);
            } else {
                $model = new OrganisationMember();
                $model->character_id = $character->id;
            }
            $model->organisation_id = $id;
            $model->role = $roles->has($key) ? $roles->get($key, '') : $newRoles->shift();
            if (request()->has('organisation_privates')) {
                $model->is_private = $privates->has($key) ? $privates->get($key, false) : $newPrivates->shift();
            } else {
                $model->is_private = false;
            }
            if ($model->save()) {
                $orgCount++;
            }
        }

        foreach ($existing as $id => $model) {
            $model->delete();
        }
    }

    /**
     * @param MiscModel $model
     */
    public function saved(MiscModel $model)
    {
        parent::saved($model);


        // Clear some cache
        CharacterCache::clearSuggestion();
    }
}
