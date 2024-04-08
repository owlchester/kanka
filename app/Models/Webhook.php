<?php

namespace App\Models;

use App\Models\Concerns\SortableTrait;
use App\Models\Concerns\Paginatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $feature_id
 * @property string $path
 * @property Feature $feature
 * @property \App\Enums\Webhook $status_id
 */
class Webhook extends Model
{
    use Paginatable;
    use SortableTrait;

    public $fillable = [
        'campaign_id',
        'action',
        'url',
        'type',
        'message',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
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

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    public function typeKey(): string
    {
        if ($this->type == 2) {
            return __('campaigns.webhooks.fields.types.payload');
        }
        return __('campaigns.webhooks.fields.types.custom');
    }

    public function actionKey(): string
    {
        if ($this->action == 1) {
            return __('campaigns.webhooks.fields.events.new');
        } elseif ($this->action == 2) {
            return __('campaigns.webhooks.fields.events.edited');
        }
        return __('campaigns.webhooks.fields.events.deleted');
    }

    public function shortUrl(): string
    {
        $pieces = parse_url($this->url);
        $domain = isset($pieces['host']) ? $pieces['host'] : '';
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
           return strstr( $regs['domain'], '.', true );
        }
        return $this->url;
    }
}
