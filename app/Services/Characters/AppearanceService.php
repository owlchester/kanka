<?php

namespace App\Services\Characters;

use App\Models\CharacterTrait;

class AppearanceService extends TraitService
{
    public int $mode = CharacterTrait::SECTION_APPEARANCE;

    public string $field = 'appearance';

    public function validate(): bool
    {
        return true;
    }
}
