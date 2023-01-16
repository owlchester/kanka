<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $family_id
 * @property array $config
 */
class FamilyTree extends Model
{
    use HasFactory;
    use Blameable;

    public $casts = [
        'config' => 'array'
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
