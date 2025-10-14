<?php

namespace App\Models;

use App\Enums\CampaignExportStatus;
use App\Models\Concerns\HasUser;
use App\Models\Concerns\SortableTrait;
use App\Observers\CampaignExportObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CampaignExport
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $status
 * @property string $path
 * @property float $progress
 */
#[ObservedBy(CampaignExportObserver::class)]
class CampaignExport extends Model
{
    use HasUser;
    use MassPrunable;
    use SortableTrait;

    public $fillable = [
        'size',
        'type',
        'status',
        'campaign_id',
        'created_by',
        'path',
    ];

    public $sortable = [
        'status',
        'type',
        'created_at',
        'created_by',
    ];

    public $casts = [
        'status' => \App\Enums\CampaignExportStatus::class,
    ];

    protected string $userField = 'created_by';

    /**
     * Automatically prune old elements from the db
     */
    public function prunable(): Builder
    {
        return static::where('updated_at', '<=', now()->subDays(90));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    public function finished(): bool
    {
        return $this->status === CampaignExportStatus::finished;
    }

    public function running(): bool
    {
        return $this->status === CampaignExportStatus::running;
    }

    public function scheduled(): bool
    {
        return $this->status === CampaignExportStatus::scheduled;
    }

    public function failed(): bool
    {
        return $this->status === CampaignExportStatus::failed;
    }
}
