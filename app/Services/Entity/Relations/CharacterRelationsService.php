<?php

namespace App\Services\Entity\Relations;

use App\Enums\OrganisationMemberPin;
use App\Enums\OrganisationMemberStatus;
use App\Facades\EntityLogger;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\Family;
use App\Models\MiscModel;
use App\Models\OrganisationMember;
use App\Models\Race;
use App\Observers\Concerns\HasMany;
use App\Services\Entity\Relations\Concerns\SavesLocations;
use App\Traits\CreatesEntityFromName;
use Illuminate\Support\Collection;

class CharacterRelationsService implements RelationsServiceInterface
{
    use CreatesEntityFromName;
    use HasMany;
    use SavesLocations;

    public function save(MiscModel $model, array $data): void
    {
        /** @var Character $model */
        $this->saveLocations($model, $data);
        $this->saveTraits($model, 'personality', $data)
            ->saveTraits($model, 'appearance', $data)
            ->saveOrganisations($model, $data)
            ->saveRaces($model, $data)
            ->saveFamilies($model, $data);

        EntityLogger::model($model)->entity($model->entity)->finish();
    }

    /** Save character traits for the given section (personality or appearance) */
    protected function saveTraits(Character $character, string $trait, array $data): self
    {
        if ($trait === 'personality' && ! auth()->user()->can('personality', $character)) {
            return $this;
        }

        $existing = [];
        foreach ($character->characterTraits()->{$trait}()->get() as $pers) {
            $existing[$pers->id] = $pers;
        }

        $traitOrder = 0;
        $traitNames = (array) ($data[$trait . '_name'] ?? []);
        $traitEntry = (array) ($data[$trait . '_entry'] ?? []);

        foreach ($traitNames as $id => $name) {
            if (empty($name)) {
                continue;
            }

            if (! empty($existing[$id])) {
                $model = $existing[$id];
                unset($existing[$id]);
            } else {
                $model = new CharacterTrait;
                $model->character_id = $character->id;
                $model->section_id = $trait === 'personality' ?
                    CharacterTrait::SECTION_PERSONALITY : CharacterTrait::SECTION_APPEARANCE;
                EntityLogger::dirty('traits', null);
            }
            $model->name = $name;
            $model->entry = $traitEntry[$id] ?? ''; // Defensive: API callers may omit entry keys for a given trait
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

    /** Save organisation memberships for the given character */
    protected function saveOrganisations(Character $character, array $data): self
    {
        if (! array_key_exists('character_save_organisations', $data)) {
            return $this;
        }

        $existing = [];
        foreach ($character->organisationMemberships()->has('organisation')->get() as $org) {
            $existing[$org->id] = $org;
        }

        $organisations = (array) ($data['organisations'] ?? []);
        $roles = new Collection($data['organisation_roles'] ?? []);
        $statuses = new Collection($data['organisation_statuses'] ?? []);
        $pins = new Collection($data['organisation_pins'] ?? []);
        $privates = new Collection($data['organisation_privates'] ?? []);

        $newRoles = new Collection;
        foreach ($roles as $id => $role) {
            if (empty($id)) {
                $newRoles->push($role);
            }
        }

        $newStatuses = new Collection;
        foreach ($statuses as $id => $status) {
            if (empty($id)) {
                $newStatuses->push($status);
            }
        }

        $newPins = new Collection;
        foreach ($pins as $id => $pin) {
            if (empty($id)) {
                $newPins->push($pin);
            }
        }

        $newPrivates = new Collection;
        foreach ($privates as $id => $private) {
            if (empty($id)) {
                $newPrivates->push($private);
            }
        }

        foreach ($organisations as $key => $id) {
            if (empty($id)) {
                continue;
            }

            if (! empty($existing[$key])) {
                $model = $existing[$key];
                unset($existing[$key]);
            } else {
                $model = new OrganisationMember;
                $model->character_id = $character->id;
                EntityLogger::dirty('organisations', null);
            }
            $model->organisation_id = (int) $id;
            $model->role = $roles->has($key) ? $roles->get($key, '') : $newRoles->shift();
            $model->pin_id = OrganisationMemberPin::tryFrom((int) ($pins->has($key) ? $pins->get($key, '') : $newPins->shift()));
            $model->status_id = OrganisationMemberStatus::from((int) ($statuses->has($key) ? $statuses->get($key, '') : $newStatuses->shift()));
            if (array_key_exists('organisation_privates', $data)) {
                $model->is_private = $privates->has($key) ? $privates->get($key, false) : $newPrivates->shift();
            } else {
                $model->is_private = false;
            }
            $model->save();
        }

        foreach ($existing as $id => $model) {
            $model->delete();
            EntityLogger::dirty('organisations', null);
        }

        return $this;
    }

    /** Save race associations for the given character */
    protected function saveRaces(Character $character, array $data): self
    {
        if (! array_key_exists('save_races', $data) && ! array_key_exists('races', $data)) {
            return $this;
        }

        $races = $this->resolveNewModels($data['races'] ?? [], Race::class, config('entities.ids.race'));
        $this->saveMany($character, 'races', $races, Race::class, 'characterRaces', 'race_id');

        return $this;
    }

    /** Save family associations for the given character */
    protected function saveFamilies(Character $character, array $data): self
    {
        if (! array_key_exists('save_families', $data) && ! array_key_exists('families', $data)) {
            return $this;
        }

        $families = $this->resolveNewModels($data['families'] ?? [], Family::class, config('entities.ids.family'));
        $this->saveMany($character, 'families', $families, Family::class);

        return $this;
    }
}
