<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $int
 * @property int $character_id
 * @property int $family_id
 * @property Carbon $created_at
 * @property Carbon $modified_at
 * @property null|Character $character
 * @property null|Family $family
 */
class CharacterFamily extends Model
{
    protected $fillable = [
        'character_id',
        'family_id',
    ];

    public $table = 'character_family';

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function exportFields(): array
    {
        return [
            'character_id',
            'family_id',
        ];
    }
}
