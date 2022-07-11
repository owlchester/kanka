<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Class Note
 * @package App\Models
 *
 * @property int $note_id
 * @property Note $note
 * @property Note[]|Collection $notes
 */
class Note extends MiscModel
{
    use CampaignTrait,
        Nested,
        ExportableTrait,
        SoftDeletes,
        Acl
    ;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'entry',
        'image',
        'type',
        'is_private',
        'note_id',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'type', 'entry'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'note';

    /**
     * Fields that can be set to null (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'note_id',
    ];



    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith(Builder $query)
    {
        return $query->with([
            'entity',
            'entity.image',
            'note',
            'note.entity',
        ]);
    }

    /**
     * Only select used fields in datagrids
     * @return array
     */
    public function datagridSelectFields(): array
    {
        return ['note_id'];
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.note');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function note()
    {
        return $this->belongsTo(Note::class, 'note_id');
    }

    /**
     * Child notes
     */
    public function notes()
    {
        return $this->hasMany(Note::class, 'note_id', 'id');
    }


    /**
     * Parent ID field for the Node trait
     * @return string
     */
    public function getParentIdName()
    {
        return 'note_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param $value
     */
    public function setNoteIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'note_id',
        ];
    }
}
