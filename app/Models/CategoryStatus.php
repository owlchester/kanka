<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property ?int $campaign_id
 * @property int $category_id
 * @property string $key
 * @property ?string $icon
 * @property int $sort_order
 * @property bool $is_default
 * @property ?Campaign $campaign
 * @property EntityType $entityType
 *
 * @method static self|Builder inCampaign(Campaign|int $campaign)
 */
class CategoryStatus extends Model
{
    public $timestamps = false;

    public $fillable = [
        'campaign_id',
        'category_id',
        'key',
        'icon',
        'sort_order',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    public function scopeInCampaign(Builder $query, Campaign|int $campaign): Builder
    {
        if ($campaign instanceof Campaign) {
            $campaign = $campaign->id;
        }

        return $query->where(function (Builder $query) use ($campaign) {
            return $query->where('campaign_id', $campaign)
                ->orWhereNull('campaign_id');
        });
    }

    /**
     * @return BelongsTo<Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * @return BelongsTo<EntityType, $this>
     */
    public function entityType(): BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'category_id');
    }

    public function name(): string
    {
        return trans('entities/statuses.' . $this->entityType->code . '.' . $this->key);
    }

    public function icon(): string
    {
        return 'fa-regular ' . ($this->icon ?? '');
    }

    public function isCustom(): bool
    {
        return $this->campaign_id !== null;
    }
}
