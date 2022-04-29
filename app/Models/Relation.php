<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\Filterable;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use App\Models\Concerns\SortableTrait;
use App\Models\Scopes\Starred;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Relation
 * @package App\Models
 * @property int $id
 * @property string $visibility
 * @property string $relation
 * @property int $attitude
 * @property int $mirror_id
 * @property int $owner_id
 * @property int $target_id
 * @property bool $is_star
 * @property string $colour
 * @property string $marketplace_uuid
 *
 * @property Relation $mirror
 * @property Entity $target
 * @property Entity $owner
 */
class Relation extends Model
{

    /**
     * Traits
     */
    use VisibilityTrait,
        Starred,
        Paginatable,
        Blameable,
        Filterable,
        Sortable,
        Searchable,
        Orderable,
        SortableTrait
    ;

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'owner_id',
        'target_id',
        'relation',
        'visibility',
        'mirror_id',
        'attitude',
        'is_star',
        'colour',
    ];

    protected $sortable = [
        'relation',
        'target.name',
        'attitude',
        'visibility',
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
    ];

    public $filterableColumns = [
        'name',
        'attitude',
        'relation',
        'owner_id',
        'target_id',
        'is_star',
        'is_mirrored',
    ];

    public $defaultOrderField = 'relation';

    /**
     * @param $query
     * @param int $star
     * @return mixed
     */
    public function scopeOrdered($query, $order = 'asc')
    {
        return $query->orderBy('relation', $order)->orderBy('attitude', 'asc');
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
    public function mirrored(): bool
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
            'visibility' => $this->visibility,
            'is_star' => $this->is_star,
            'mirror_id' => $this->id,
        ]);

        // Update this relation to keep track of everything
        $this->update(['mirror_id' => $mirror->id]);
    }

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
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
     * When setting the colour, remove the '#' from the db
     * @param $colour
     */
    public function setColourAttribute($colour)
    {
        $this->attributes['colour'] = ltrim($colour, '#');
    }

    /**
     * When setting the colour, remove the '#' from the db
     * @param $colour
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
    public function entityTypeID()
    {
        return 0;
    }

    /**
     * Functions for the datagrid2
     * @param string $where
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
    public function routeParams(): array
    {
        return [$this->owner_id, $this->id, 'mode' => 'table'];
    }
    public function actionDeleteConfirmOptions(): string
    {
        return 'data-mirrored="' . $this->mirrored() . '"';
    }
}
