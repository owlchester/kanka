<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use App\Models\Concerns\SortableTrait;
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
class CampaignExport extends Model
{
    use HasUser;
    use MassPrunable;
    use SortableTrait;

    public const int TYPE_ENTITIES = 1;

    public const int TYPE_ASSETS = 2;

    public const int STATUS_SCHEDULED = 1;

    public const int STATUS_RUNNING = 2;

    public const int STATUS_FINISHED = 3;

    public const int STATUS_FAILED = 4;

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

    protected string $userField = 'created_by';

    /**
     * Automatically prune old elements from the db
     */
    public function prunable(): Builder
    {
        return static::where('updated_at', '<=', now()->subDays(90));
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    public function finished(): bool
    {
        return $this->status === CampaignExport::STATUS_FINISHED;
    }

    public function running(): bool
    {
        return $this->status === CampaignExport::STATUS_RUNNING;
    }

    public function scheduled(): bool
    {
        return $this->status === CampaignExport::STATUS_SCHEDULED;
    }

    public function failed(): bool
    {
        return $this->status === CampaignExport::STATUS_FAILED;
    }
}
