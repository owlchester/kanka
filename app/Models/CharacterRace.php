<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $character_id
 * @property int $race_id
 */
class CharacterRace extends Model
{
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}
