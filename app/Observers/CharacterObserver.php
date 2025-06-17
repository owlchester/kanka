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
        $this
            ->saveRaces($character)
            ->saveFamilies($character);

        EntityLogger::model($character)->entity($character->entity)->finish();
    }

    protected function saveRaces(Character $character): self
    {
        if (! request()->has('save_races') && ! request()->has('races')) {
            return $this;
        }

        $this->saveMany($character, 'races', request()->get('races', []), Race::class, 'characterRaces', 'race_id');

        return $this;
    }

    protected function saveFamilies(Character $character): self
    {
        if (! request()->has('save_families') && ! request()->has('families')) {
            return $this;
        }
        $this->saveMany($character, 'families', request()->get('families', []), Family::class);

        return $this;
    }
}
