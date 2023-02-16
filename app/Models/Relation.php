<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Concerns\SortableTrait;
use App\Models\Scopes\Starred;
use App\Traits\VisibilityIDTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Relation
 * @package App\Models
 * @property int $id
 * @property string $relation
 * @property int $attitude
 * @property int|null $mirror_id
 * @property int $owner_id
 * @property int $target_id
 * @property bool $is_star
 * @property string $colour
 * @property string $marketplace_uuid
 *
 * @property Relation|null $mirror
 * @property Entity|null $target
 * @property Entity $owner
 * @property int $created_at
 * @property int $updated_at
 */
class Relation extends Model
{
    use Blameable;
    use HasFilters;
    use Orderable;
    use Paginatable;
    use Searchable;
    use Sortable;
    use SortableTrait
    ;
    use Starred;
    /**
     * Traits
     */
    use VisibilityIDTrait;

    /** @var string[]  */
    protected $fillable = [
        'campaign_id',
        'owner_id',
        'target_id',
        'relation',
        'visibility_id',
        'mirror_id',
        'attitude',
        'is_star',
        'colour',
    ];

    protected $sortable = [
        'relation',
        'target.name',
        'attitude',
        'visibility_id',
    ];

    /**
     * Fields that can be sorted on
     * @var array
     */
    public $sortableColumns = [
        'owner_id',
        'target_id',
        'relation',
        'attitude',
        'is_star',
        'mirror_id',
        'visibility_id',
    ];

    public $defaultOrderField = 'relation';

    /**
     * @param Builder $query
     * @param string $order
     * @return Builder
     */
    public function scopeOrdered(Builder$query, $order = 'asc'): Builder
    {
        return $query
            ->orderBy('relation', $order)
            ->orderBy('attitude', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\Entity', 'owner_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function target()
    {
        return $this->belongsTo('App\Models\Entity', 'target_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mirror()
    {
        return $this->belongsTo('App\Models\Relation', 'mirror_id', 'id');
    }

    /**
     * Check if a relation is mirrored
     * @return bool
     */
    public function isMirrored(): bool
    {
        return !empty($this->mirror_id);
    }

    /**
     * Create a mirror of the relation
     */
    public function createMirror(): void
    {
        $target = request()->get('target_relation');
        $mirror = Relation::create([
            'owner_id' => $this->target_id,
            'target_id' => $this->owner_id,
            'campaign_id' => $this->campaign_id,
            'relation' => !empty($target) ? $target : $this->relation,
            'attitude' => $this->attitude,
            'colour' => $this->colour,
            'visibility_id' => $this->visibility_id,
            'is_star' => $this->is_star,
            'mirror_id' => $this->id,
        ]);

        // Update this relation to keep track of everything
        $this->update(['mirror_id' => $mirror->id]);
    }

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query
            ->with([
                'owner',
                'target',
            ])
            ->has('owner')
            ->has('target')
        ;
    }

    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedSelect(Builder $query): Builder
    {
        return $query
            ->select(['id', 'target_id', 'owner_id', 'relation', 'mirror_id', 'is_star', 'attitude', 'visibility_id'])
        ;
    }

    /**
     * When setting the colour, remove the '#' from the db
     * @param string $colour
     */
    public function setColourAttribute($colour)
    {
        $this->attributes['colour'] = ltrim($colour, '#');
    }

    /**
     * When getting the colour, remove the '#' from the db
     */
    public function getColourAttribute(): string
    {
        if (empty($this->attributes['colour'])) {
            return '';
        }
        return '#' . $this->attributes['colour'];
    }

    public function getEntityType()
    {
        return 'relation';
    }

    /**
     * Faker event
     */
    public function crudSaved()
    {
        return $this;
    }

    /** Fake entity type ID */
    public function entityTypeID(): int
    {
        return 0;
    }

    /**
     * Functions for the datagrid2
     * @return string
     */
    public function deleteName(): string
    {
        return (string) $this->relation;
    }
    public function url(string $where): string
    {
        return 'entities.relations.' . $where;
    }
    public function routeParams(array $options = []): array
    {
        return [$this->campaign_id, $this->owner_id, $this->id, 'mode' => 'table'];
    }
    public function actionDeleteConfirmOptions(): string
    {
        return 'data-mirrored="' . $this->isMirrored() . '"';
    }

    /**
     * Relations don't use the default filterable columns available to entities
     * @return array
     */
    protected function defaultFilterableColumns(): array
    {
        return [];
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'name',
            'attitude',
            'relation',
            'owner_id',
            'target_id',
            'is_star',
            'is_mirrored',
        ];
    }
}
