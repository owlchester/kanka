<?php

namespace App\Models;

use App\Enums\Visibility;
use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
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
 * @method static Builder|self sort(array $filters, array $defaultOrder = [])
 */
class EntityAbility extends Model
{
    use Blameable;
    use HasFactory;
    use HasVisibility;
    use Sanitizable;
    use SortableTrait;

    protected array $sortable = ['type_id'];

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
        'visibility_id' => Visibility::class,
    ];

    protected array $sanitizable = [
        'note',
    ];

    /**
     * @return BelongsTo<Entity, $this>
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity');
    }

    /**
     * @return BelongsTo<Ability, $this>
     */
    public function ability(): BelongsTo
    {
        return $this->belongsTo('App\Models\Ability');
    }

    public function scopeDefaultOrder(Builder $query): Builder
    {
        return $query
            ->select('entity_abilities.*')
            ->leftJoin('entities as default_e', 'default_e.id', '=', 'entity_abilities.entity_id')
            ->leftJoin('abilities as default_a', 'default_a.id', '=', 'entity_abilities.ability_id')
            ->orderBy('position')
            ->orderBy('default_e.type')
            ->orderBy('default_a.name');
    }

    public function scopeCustomSortType_id(Builder $query, string $order): Builder
    {
        return $query
            ->select('entity_abilities.*')
            ->leftJoin('entities as sort_e', 'sort_e.id', '=', 'entity_abilities.entity_id')
            ->orderBy('sort_e.type', $order);
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

    public function url(string $sub): string
    {
        return 'entities.entity_abilities.' . $sub;
    }
}
