<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasVisibility;
use App\Models\Concerns\Sanitizable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    use HasCampaign;
    use HasVisibility;
    use Sanitizable;

    public $fillable = [
        'name',
        'type_id',
        'config',
        'visibility_id',
        'campaign_id',
    ];

    public $casts = [
        'config' => 'array',
        'visibility_id' => \App\Enums\Visibility::class,
    ];

    protected array $sanitizable = [
        'name',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(PresetType::class);
    }

    public function scopeInType(Builder $builder, int $type): Builder
    {
        return $builder->where('type_id', $type);
    }
}
