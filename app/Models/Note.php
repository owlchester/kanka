<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Nested;
use App\Models\Concerns\Sanitizable;
use App\Observers\NoteObserver;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Class Note
 *
 * @property ?int $note_id
 */
class Note extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use HasRecursiveRelationships;
    use Nested;
    use Sanitizable;
    use SoftDeletes;

    protected $fillable = [
        'campaign_id',
        'name',
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
    ];

    protected static function booted()
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }
        static::observe(NoteObserver::class);
    }

    /**
     * Performance with for datagrids
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return parent::scopePreparedWith($query);
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
     *
     * @return string
     */
    public function getParentKeyName()
    {
        return 'note_id';
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'note_id',
        ];
    }
}
