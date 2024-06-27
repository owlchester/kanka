<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $character_id
 * @property int $race_id
 */
class CharacterRace extends Model
{
    public $table = 'character_race';

    protected $fillable = [
        'character_id',
        'race_id',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}
