<?php

namespace App\Models;

use App\Models\Concerns\Privatable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $int
 * @property int $character_id
 * @property int $family_id
 * @property Carbon $created_at
 * @property Carbon $modified_at
 * @property ?Character $character
 * @property ?Family $family
 */
class CharacterFamily extends Model
{
    use Privatable;

    protected $fillable = [
        'character_id',
        'family_id',
        'is_private',
    ];

    public $table = 'character_family';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Character, $this>
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Family, $this>
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function getCharacterFamiliesAttribute()
    {
        return $this->character->races;
    }

    public function exportFields(): array
    {
        return [
            'character_id',
            'family_id',
        ];
    }
}
