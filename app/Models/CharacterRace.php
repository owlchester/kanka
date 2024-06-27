<?php

namespace App\Models;

use App\Models\Concerns\Privatable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $character_id
 * @property int $race_id
 * @property bool $is_private
 */
class CharacterRace extends Model
{
    use Privatable;

    public $table = 'character_race';

    protected $fillable = [
        'character_id',
        'race_id',
        'is_private',
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
