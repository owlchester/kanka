<?php

namespace App\Models;

use App\Models\Concerns\HasEntry;
use App\Models\Concerns\Paginatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CharacterTrait
 * @package App\Models
 *
 * @property int $id
 * @property int $character_id
 * @property string $name
 * @property string $entry
 * @property int $section_id
 * @property bool|int $is_private
 * @property int $default_order
 */
class CharacterTrait extends Model
{
    use HasEntry;
    use Paginatable;

    public const int SECTION_APPEARANCE = 1;
    public const int SECTION_PERSONALITY = 2;

    protected $fillable = [
        'character_id',
        'name',
        'entry',
        'section_id',
        'created_by',
        'is_private',
        'default_order',
    ];


    /**
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }

    /**
     */
    public function scopePersonality(Builder $query): Builder
    {
        return $query->where('section_id', self::SECTION_PERSONALITY);
    }

    /**
     */
    public function scopeAppearance(Builder $query): Builder
    {
        return $query->where('section_id', self::SECTION_APPEARANCE);
    }

    public function exportFields(): array
    {
        return [
            'name',
            'entry',
            'is_private',
            'section_id',
            'default_order',
        ];
    }
}
