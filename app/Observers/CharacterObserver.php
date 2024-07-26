<?php

namespace App\Observers;

use App\Facades\EntityLogger;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\Family;
use App\Models\OrganisationMember;
use App\Models\Race;
use App\Observers\Concerns\HasMany;
use Illuminate\Support\Collection;

class CharacterObserver extends MiscObserver
{
    use HasMany;

    public function crudSaved(Character $character)
    {
        $this->saveTraits($character, 'personality')
            ->saveTraits($character, 'appearance')
            ->saveOrganisations($character)
            ->saveRaces($character)
            ->saveFamilies($character)
        ;

        EntityLogger::model($character)->entity($character->entity)->finish();
    }

    /**
     * @return $this
     */
    protected function saveTraits(Character $character, string $trait = 'personality'): self
    {
        // Users who can edit the character but can't access personality traits shouldn't be allowed to
        // change those traits.
        if ($trait == 'personality' && !auth()->user()->can('personality', $character)) {
            return $this;
        }

        $existing = [];
        foreach ($character->characterTraits()->{$trait}()->get() as $pers) {
            $existing[$pers->id] = $pers;
        }

        $traitOrder = 0;
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
                $model->section_id = $trait == 'personality' ?
                    CharacterTrait::SECTION_PERSONALITY : CharacterTrait::SECTION_APPEARANCE;
                EntityLogger::dirty('traits', null);
            }
            $model->name = $name;
            $model->entry = $traitEntry[$id];
            $model->default_order = $traitOrder;
            $model->save();
            $traitOrder++;
        }

        foreach ($existing as $id => $model) {
            $model->delete();
            EntityLogger::dirty('traits', null);
        }

        return $this;
    }

    /**
     * Save a character's organisations
     */
    protected function saveOrganisations(Character $character): self
    {
        // If the organisations array isn't provided, skip this feature. The crud interface will always provide one,
        // and the api calls will provide one if necessary.
        if (!request()->has('character_save_organisations')) {
            return $this;
        }

        $existing = [];
        /** @var OrganisationMember $org */
        foreach ($character->organisationMemberships()->has('organisation')->get() as $org) {
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
                EntityLogger::dirty('organisations', null);
            }
            $model->organisation_id = $id;
            $model->role = $roles->has($key) ? $roles->get($key, '') : $newRoles->shift();
            $model->pin_id = $pins->has($key) ? $pins->get($key, '') : $newPins->shift();
            $model->status_id = $statuses->has($key) ? $statuses->get($key, '') : $newStatuses->shift();
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
            EntityLogger::dirty('organisations', null);
        }

        return $this;
    }

    /**
     */
    protected function saveRaces(Character $character): self
    {
        if (!request()->has('save_races') && !request()->has('races')) {
            return $this;
        }

        $this->saveMany($character, 'races', request()->get('races', []), Race::class, 'characterRaces', 'race_id');

        return $this;
    }

    /**
     */
    protected function saveFamilies(Character $character): self
    {
        if (!request()->has('save_families') && !request()->has('families')) {
            return $this;
        }
        $this->saveMany($character, 'families', request()->get('families', []), Family::class);

        return $this;
    }
}
