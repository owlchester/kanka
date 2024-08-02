<?php

namespace App\Models;

use App\User;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CampaignExport
 * @package App\Models
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $created_by
 * @property int $status
 * @property string $path
 * @property float $progress
 *
 */
class CampaignExport extends Model
{
    use MassPrunable;
    use SortableTrait;

    public const TYPE_ENTITIES = 1;
    public const TYPE_ASSETS = 2;

    public const STATUS_SCHEDULED = 1;
    public const STATUS_RUNNING = 2;
    public const STATUS_FINISHED = 3;
    public const STATUS_FAILED = 4;

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

    /**
     * Automatically prune old elements from the db
     */
    public function prunable(): Builder
    {
        return static::where('updated_at', '<=', now()->subDays(90));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
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
}
