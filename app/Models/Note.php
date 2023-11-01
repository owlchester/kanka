<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\Nested;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Note
 * @package App\Models
 *
 * @property int|null $note_id
 * @property Note|null $note
 * @property Note[]|Collection $notes
 */
class Note extends MiscModel
{
    use Acl;
    use CampaignTrait;
    use ExportableTrait;
    use HasFactory;
    use Nested;
    use SoftDeletes;

    /** @var string[]  */
    protected $fillable = [
        'campaign_id',
        'name',
        'slug',
        'entry',
        'type',
        'is_private',
        'note_id',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'note';

    /**
     * Fields that can be set to null (foreign keys)
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'note_id',
    ];



    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_path', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
            'note' => function ($sub) {
                $sub->select('id', 'name');
            },
            'note.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
            },
            'notes' => function ($sub) {
                $sub->select('id', 'note_id', 'name');
            },
            'children' => function ($sub) {
                $sub->select('id', 'note_id');
            }
        ]);
    }

    /**
     * Only select used fields in datagrids
     */
    public function datagridSelectFields(): array
    {
        return ['note_id'];
    }

    /**
     * Get the entity_type id from the entity_types table
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
     * @param int $value
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
