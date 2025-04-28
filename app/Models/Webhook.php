<?php

namespace App\Models;

use App\Enums\WebhookAction;
use App\Facades\CampaignLocalization;
use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\Paginatable;
use App\Models\Concerns\SortableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;

/**
 * @property int $id
 * @property int $feature_id
 * @property int $status
 * @property string $path
 * @property Feature $feature
 * @property int $action
 * @property array|null $settings
 */
class Webhook extends Model
{
    use HasCampaign;
    use Paginatable;
    use SortableTrait;

    public $fillable = [
        'action',
        'url',
        'type',
        'message',
        'status',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    protected array $sortable = [
        'type',
        'status',
        'action',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            'App\Models\Tag',
            'webhook_tags',
            'webhook_id',
            'tag_id',
            'id',
            'id'
        );
    }

    public function typeKey(): string
    {
        if ($this->type == 2) {
            return __('campaigns/webhooks.fields.types.payload');
        }

        return __('campaigns/webhooks.fields.types.custom');
    }

    public function actionKey(): string
    {
        $campaign = CampaignLocalization::getCampaign();
        $action = __('campaigns/webhooks.fields.events.deleted');

        if ($this->action === WebhookAction::CREATED->value) {
            $action = __('campaigns/webhooks.fields.events.new');
        } elseif ($this->action === WebhookAction::EDITED->value) {
            $action = __('campaigns/webhooks.fields.events.edited');
        }

        return '<a class="name" href="' . route('webhooks.edit', [$campaign, $this->id]) . '">' . $action . '</a>';
    }

    public function shortUrl(): string
    {
        $pieces = parse_url($this->url);
        $domain = $pieces['host'] ?? '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
            return mb_strstr($regs['domain'], '.', true);
        }

        return $this->url;
    }

    public function scopeActive(Builder $query, int $campaignId, int $action): Builder
    {
        return $query
            ->where('campaign_id', $campaignId)
            ->where('action', $action)
            ->where('status', 1);
    }

    public function isActive(): bool
    {
        return $this->status == 1;
    }

    public function skipPrivate(): bool
    {
        if (Arr::has($this->settings, 'skip_private')) {
            return Arr::get($this->settings, 'skip_private');
        }

        return false;
    }
}
