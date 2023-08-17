<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Traits\CampaignTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $system
 * @property string $parameters
 * @property int $character_id
 */
class DiceRoll extends MiscModel
{
    use Acl;
    use CampaignTrait;
    use SoftDeletes;

    /** @var string[]  */
    protected $fillable = [
        'name',
        'slug',
        'campaign_id',
        'character_id',
        'system',
        'parameters',
        'is_private',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected array $searchableColumns  = ['name'];

    /**
     * Fields that can be sorted on
     * @var array
     */
    protected array $sortableColumns = [
        'parameters',
        'character.name',
    ];

    /**
     * Nullable values (foreign keys)
     * @var string[]
     */
    public $nullableForeignKeys = [
        'character_id',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'dice_roll';

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diceRollResults()
    {
        return $this->hasMany('App\Models\DiceRollResult', 'dice_roll_id');
    }

    /**
     * Get the entity_type id from the entity_types table
     * @return int
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.dice_roll');
    }

    /**
     * @return mixed|string
     */
    public function entry()
    {
        return '';
    }

    /**
     * Determine if the model has profile data to be displayed
     * @return bool
     */
    public function showProfileInfo(): bool
    {
        return $this->parameters || $this->character;
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'character_id',
        ];
    }
    /**
     * Performance with for datagrids
     * @param Builder $query
     * @return Builder
     */
    public function scopePreparedWith(Builder $query): Builder
    {
        return $query->with([
            'entity' => function ($sub) {
                $sub->select('id', 'name', 'entity_id', 'type_id', 'image_uuid', 'focus_x', 'focus_y');
            },
            'entity.image' => function ($sub) {
                $sub->select('campaign_id', 'id', 'ext', 'focus_x', 'focus_y');
            },
            'character' => function ($sub) {
                $sub->select('id', 'name');
            },
        ]);
    }
}
