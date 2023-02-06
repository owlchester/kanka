<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Traits\CampaignTrait;
use App\Traits\VisibilityIDTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property array $config
 *
 * @property int $type_id
 * @property PresetType $type
 *
 * @method static Builder|self inType(int $type)
 */
class Preset extends Model
{
    use Blameable;
    use CampaignTrait;
    use VisibilityIDTrait;

    public $fillable = [
        'name',
        'type_id',
        'config',
        'visibility_id',
    ];

    public $casts = [
        'config' => 'array'
    ];

    public function type()
    {
        return $this->belongsTo(PresetType::class);
    }

    public function scopeInType(Builder $builder, int $type): Builder
    {
        return $builder->where('type_id', $type);
    }
}
