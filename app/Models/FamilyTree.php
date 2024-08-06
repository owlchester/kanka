<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $family_id
 * @property array $config
 */
class FamilyTree extends Model
{
    use Blameable;
    use HasFactory;

    public $casts = [
        'config' => 'array'
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
