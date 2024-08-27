<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasUser;
use App\Models\Concerns\Orderable;
use App\Models\Concerns\Searchable;
use App\Models\Concerns\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ?DiceRoll $diceRoll
 * @property ?int $dice_roll_id
 * @property int|bool $is_private
 * @property string $results
 */
class DiceRollResult extends Model
{
    use Blameable;
    use HasFilters;
    use HasUser;
    use Orderable;
    use Searchable;
    use Sortable;

    protected $fillable = [
        'dice_roll_id',
        'created_by',
        'results',
        'is_private',
    ];

    /**
     * Fields that can be sorted on
     */
    protected array $sortableColumns = [
        'diceRoll.name',
        'character.name',
        'user.name',
        'results',
        'created_at',
    ];

    protected string $defaultOrderField = 'created_at';
    protected string $defaultOrderDirection = 'DESC';
    protected string $userField = 'created_by';

    /**
     * We want to use the dice_roll entity type for permissions
     */
    protected string $entityType = 'dice_roll';

    /** @var bool No relations for this entity "type" */
    protected bool $hasRelations = false;

    /**
     * Who created this entry
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function diceRoll(): BelongsTo
    {
        return $this->belongsTo('App\Models\DiceRoll', 'dice_roll_id');
    }

    /**
     */
    public function character()
    {
        return $this->diceRoll->character();
    }

    /**
     * Define the fields unique to this model that can be used on filters
     * @return string[]
     */
    public function filterableColumns(): array
    {
        return [
            'dice_roll_id',
            'created_at',
            'created_by',
            'diceRoll-character_id',
        ];
    }
}
