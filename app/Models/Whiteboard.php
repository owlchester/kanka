<?php

namespace App\Models;

use App\Models\Concerns\Acl;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\Sanitizable;
use App\Models\Concerns\SortableTrait;
use App\Traits\ExportableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property int|bool $is_private
 * @property array $data
 * @property WhiteboardShape[]|Collection $shapes
 */
class Whiteboard extends MiscModel
{
    use Acl;
    use ExportableTrait;
    use HasCampaign;
    use HasFilters;
    use Sanitizable;
    use SoftDeletes;
    use SortableTrait;

    public $fillable = [
        'campaign_id',
        'name',
        'data',
        'is_private',
    ];

    public $casts = [
        'data' => 'array',
    ];

    protected array $sortable = [
        'name',
    ];

    protected array $sanitizable = [
        'name',
    ];

    /**
     * Get the entity_type id from the entity_types table
     */
    public function entityTypeId(): int
    {
        return (int) config('entities.ids.whiteboard');
    }

    public function shapes(): HasMany
    {
        return $this->hasMany(WhiteboardShape::class);
    }
}
