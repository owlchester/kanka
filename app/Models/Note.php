<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasEntry;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Note
 * @package App\Models
 *
 * @property int|null $note_id
 */
class Note extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasEntry;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use Nested;
    use Sanitizable;
    use SoftDeletes;

    protected $fillable = [
        'campaign_id',
        'name',
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
     */
    public array $nullableForeignKeys = [
        'note_id',
    ];

    protected array $exportFields = [
        'base',
    ];

    protected array $sanitizable = [
        'name',
        'type',
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
            'parent' => function ($sub) {
                $sub->select('id', 'name');
            },
            'parent.entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id');
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
     * Parent ID field for the Node trait
     * @return string
     */
    public function getParentKeyName()
    {
        return 'note_id';
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
