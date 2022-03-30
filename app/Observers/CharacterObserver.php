<?php

namespace App\Observers;

use App\Facades\CharacterCache;
use App\Models\CharacterTrait;
use App\Models\Family;
use App\Models\MiscModel;
use App\Models\OrganisationMember;
use App\Models\Race;
use Illuminate\Support\Collection;

class CharacterObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function crudSaved(MiscModel $model)
    {
        parent::crudSaved($model);
        $this->saveTraits($model, 'personality')
            ->saveTraits($model, 'appearance')
            ->saveOrganisations($model)
            ->saveRaces($model)
            ->saveFamilies($model)
        ;
    }

    /**
     * @param MiscModel $model
     */
    protected function saveTraits(MiscModel $character, $trait = 'personality'): self
    {
        // Users who can edit the character but can't access personality traits shouldn't be allowed to
        // change those traitrs.
        if ($trait == 'personality' && !auth()->user()->can('personality', $character)) {
            return $this;
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
                $model->section_id = $trait == 'personality' ? CharacterTrait::SECTION_PERSONALITY : CharacterTrait::SECTION_APPEARANCE;
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

        return $this;
    }

    /**
     * Save a character's organisations
     * @param MiscModel $character
     * @throws \Exception
     */
    protected function saveOrganisations(MiscModel $character): self
    {
        // If the organisations array isn't provided, skip this feature. The crud interface will always provide one,
        // and the api calls will provide one if necessary.
        if (!request()->has('character_save_organisations')) {
            return $this;
        }

        /** @var OrganisationMember $org */
        $existing = [];
        foreach ($character->organisations()->has('organisation')->get() as $org) {
            $existing[$org->id] = $org;
        }

        $orgCount = 0;
        $organisations = request()->post('organisations', []);
        $roles = new Collection(request()->post('organisation_roles', []));
        $statuses = new Collection(request()->post('organisation_statuses', []));
        $pins = new Collection(request()->post('organisation_pins', []));
        $privates = new Collection(request()->post('organisation_privates', []));

        // Prepare roles and permissions that a new (have no id) to properly map them with new organisations
        $newRoles = new Collection();
        foreach ($roles as $id => $role) {
            if (empty($id)) {
                $newRoles->push($role);
            }
        }

        $newStatuses = new Collection();
        foreach ($statuses as $id => $status) {
            if (empty($id)) {
                $newStatuses->push($status);
            }
        }

        $newPins = new Collection();
        foreach ($pins as $id => $pin) {
            if (empty($id)) {
                $newPins->push($pin);
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

            if (!empty($existing[$key])) {
                $model = $existing[$key];
                unset($existing[$key]);
            } else {
                $model = new OrganisationMember();
                $model->character_id = $character->id;
            }
            $model->organisation_id = $id;
            $model->role = $roles->has($key) ? $roles->get($key, '') : $newRoles->shift();
            $model->pin_id = $pins->has($key) ? $pins->get($key,  '') : $newPins->shift();
            $model->status_id = $statuses->has($key) ? $statuses->get($key,  '') : $newStatuses->shift();
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

        return $this;
    }

    /**
     * @param MiscModel $character
     */
    protected function saveRaces(MiscModel $character): self
    {
        if (!request()->has('save_races') && !request()->has('races')) {
            return $this;
        }

        /** @var Race $races */
        $existing = [];
        $unique = [];
        $recreate = [];
        foreach ($character->races as $race) {
            // If it already exists, we have an issue
            if (!empty($existing[$race->id])) {
                $recreate[$race->id] = $race->id;
                $character->races()->detach($race->id);
                continue;
            }
            $existing[$race->id] = $race->id;
            $unique[$race->id] = $race->id;
        }

        if (!empty($recreate)) {
            $character->races()->attach($recreate);
        }

        $races = request()->get('races', []);
        $newRaces = [];
        foreach ($races as $id) {
            // Existing race, do nothing
            if (!empty($existing[$id])) {
                unset($existing[$id]);
                continue;
            }
            // If already managed, again, ignore
            if (!empty($unique[$id])) {
                continue;
            }

            $race = Race::find($id);
            if (empty($race)) {
                continue;
            }
            $newRaces[] = $race->id;

        }
        $character->races()->attach($newRaces);

        // Detach the remaining
        if (!empty($existing)) {
            $character->races()->detach($existing);
        }

        return $this;
    }

    /**
     * @param MiscModel $character
     */
    protected function saveFamilies(MiscModel $character): self
    {
        if (!request()->has('save_families') && !request()->has('families')) {
            return $this;
        }

        /** @var Family $families */
        $existing = [];
        $unique = [];
        $recreate = [];
        foreach ($character->families as $family) {
            // If it already exists, we have an issue
            if (!empty($existing[$family->id])) {
                $recreate[$family->id] = $family->id;
                $character->families()->detach($family->id);
                continue;
            }
            $existing[$family->id] = $family->id;
            $unique[$family->id] = $family->id;
        }

        if (!empty($recreate)) {
            $character->families()->attach($recreate);
        }

        $families = request()->get('families', []);
        $newFamilies = [];
        foreach ($families as $id) {
            // Existing race, do nothing
            if (!empty($existing[$id])) {
                unset($existing[$id]);
                continue;
            }
            // If already managed, again, ignore
            if (!empty($unique[$id])) {
                continue;
            }

            $family = Family::find($id);
            if (empty($family)) {
                continue;
            }
            $newFamilies[] = $family->id;

        }
        $character->families()->attach($newFamilies);

        // Detach the remaining
        if (!empty($existing)) {
            $character->families()->detach($existing);
        }

        return $this;
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
