<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Sanitizable;
use App\Observers\DiceRollObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $system
 * @property string $parameters
 * @property ?int $character_id
 * @property ?Character $character
 */
class DiceRoll extends MiscModel
{
    use Acl;
    use HasCampaign;
    use HasFactory;
    use HasFilters;
    use Sanitizable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'campaign_id',
        'character_id',
        'system',
        'parameters',
        'is_private',
    ];

    /**
     * Searchable fields
     */
    protected array $searchableColumns = ['name'];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'parameters',
        'character.name',
    ];

    /**
     * Nullable values (foreign keys)
     *
     * @var string[]
     */
    public array $nullableForeignKeys = [
        'character_id',
    ];

    /**
     * Entity type
     */
    protected string $entityType = 'dice_roll';

    protected array $sanitizable = [
        'name',
        'parameters',
    ];

    protected static function booted()
    {
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }
        static::observe(DiceRollObserver::class);
    }

    /**
     * Who created this entry
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }

    public function diceRollResults(): HasMany
    {
        return $this->hasMany('App\Models\DiceRollResult', 'dice_roll_id');
    }

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.dice_roll');
    }

    /**
     * Determine if the model has profile data to be displayed
     */
    public function showProfileInfo(): bool
    {
        return $this->parameters || $this->character;
    }

    /**
     * Define the fields unique to this model that can be used on filters
     *
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
     */
    public function scopePreparedWith(Builder $query): Builder
    {

        return parent::scopePreparedWith($query->with([
            'character' => function ($sub) {
                $sub->select('id', 'name');
            },
            'character.entity',
        ]));
    }
}
