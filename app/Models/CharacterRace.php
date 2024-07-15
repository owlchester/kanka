<?php

namespace App\Models;

use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Privatable;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $character_id
 * @property int $race_id
 * @property bool|int $is_private
 * @property null|Character $character
 * @property null|Race $race
 * @property Collection|Race[] $characterRaces
 */
class CharacterRace extends Model
{
    use HasFilters;
    use Paginatable;
    use Privatable;
    use SortableTrait;

    public $table = 'character_race';

    protected $fillable = [
        'character_id',
        'race_id',
        'is_private',
    ];

    protected array $sortable = [
        'character.name',
        'character.type',
    ];

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }

    public function getCharacterRacesAttribute()
    {
        return $this->character->races;
    }

    public function getCharacterLocationAttribute()
    {
        return $this->character->location;
    }
}
