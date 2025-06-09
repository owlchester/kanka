<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Sanitizable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class EntityAbility
 *
 * @property int $id
 * @property int $entity_id
 * @property int $ability_id
 * @property int $charges
 * @property int $position
 * @property string $note
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Ability|null $ability
 * @property ?Entity $entity
 *
 * @method static Builder|self defaultOrder()
 */
class EntityAbility extends Model
{
    use Blameable;
    use HasFactory;
    use HasVisibility;
    use Sanitizable;

    /**
     * Fillable fields
     */
    public $fillable = [
        'entity_id',
        'ability_id',
        'visibility_id',
        'created_by',
        'charges',
        'position',
        'note',
    ];

    public $casts = [
        'visibility_id' => \App\Enums\Visibility::class,
    ];

    protected array $sanitizable = [
        'note',
    ];

    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity');
    }

    public function ability(): BelongsTo
    {
        return $this->belongsTo('App\Models\Ability');
    }

    /**
     * @return Builder
     */
    public function scopeDefaultOrder(Builder $query)
    {
        return $query
            ->orderBy('position')
            ->orderBy('ae.type')
            ->orderBy('a.name');
    }

    /**
     * Copy an entity ability to another target
     */
    public function copyTo(Entity $target)
    {
        $new = $this->replicate(['entity_id']);
        $new->entity_id = $target->id;

        return $new->save();
    }

    public function exportFields(): array
    {
        return [
            'ability_id',
            'visibility_id',
            'created_by',
            'charges',
            'position',
            'note',
        ];
    }
}
