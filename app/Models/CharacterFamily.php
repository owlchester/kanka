<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $int
 * @property int $character_id
 * @property int $family_id
 * @property Carbon $created_at
 * @property Carbon $modified_at
 */
class CharacterFamily extends Model
{
    public $table = 'character_family';

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
