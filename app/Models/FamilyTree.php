<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Observers\FamilyTreeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $family_id
 * @property array $config
 */
#[ObservedBy(FamilyTreeObserver::class)]
class FamilyTree extends Model
{
    use Blameable;
    use HasFactory;

    protected $fillable = [
        'family_id',
        'config',
    ];

    public $casts = [
        'config' => 'array',
    ];

    /**
     * @return BelongsTo<Family, $this>
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
