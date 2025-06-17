<?php

namespace App\Services\Characters;

use App\Facades\EntityLogger;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Traits\RequestAware;
use App\Traits\UserAware;

class PersonalityService extends TraitService
{
    public int $mode = CharacterTrait::SECTION_PERSONALITY;

    public string $field = 'personality';
    protected function validate(): bool
    {
        // Users who can edit the character but can't access personality traits shouldn't be allowed to
        // change those traits.
        return $this->user->can('personality', $this->character);
    }


}
