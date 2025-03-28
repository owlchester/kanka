<?php

namespace App\Models;

use App\Observers\CampaignPluginObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CampaignPlugin
 *
 * @property int $campaign_id
 * @property int $created_by
 * @property int $plugin_id
 * @property int $plugin_version_id
 * @property string $name
 * @property bool|int $is_active
 * @property Plugin $plugin
 * @property Campaign $campaign
 * @property PluginVersion $version
 *
 * @method static self|Builder templates(Campaign $campaign)
 */
class CampaignPlugin extends Model
{
    protected static function booted()
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }
        static::observe(CampaignPluginObserver::class);
    }

    public function plugin(): BelongsTo
    {
        return $this->belongsTo(Plugin::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function version(): BelongsTo
    {
        return $this->belongsTo(PluginVersion::class, 'plugin_version_id');
    }

    public function scopeTemplates(Builder $builder, Campaign $campaign): Builder
    {
        return $builder->leftJoin('plugins as p', 'p.id', 'plugin_id')
            ->where('campaign_id', $campaign->id)
            ->where('p.type_id', 2)
            ->where('is_active', true)
            ->with('version')
            ->orderBy('p.name');
    }

    public function canEnable(): bool
    {
        return $this->plugin->isTheme() && ! $this->is_active;
    }

    public function canDisable(): bool
    {
        return $this->plugin->isTheme() && $this->is_active;
    }

    /**
     * Determine if the plug can be rendered. This is needed for character sheets in draft statuses,
     * to only render a sheet for the author, as they can potentially add XSS injections.
     */
    public function renderable(): bool
    {
        if (! $this->plugin->isAttributeTemplate()) {
            return false;
        } elseif ($this->version->status_id === 3) {
            // Published version? We good
            return true;
        }

        // The user needs to be an author
        return $this->isAuthor();
    }

    /**
     * Check if the current user is an author of a plugin
     */
    public function isAuthor(): bool
    {
        if (auth()->guest()) {
            return false;
        }

        return $this->plugin->created_by === auth()->user()->id;
    }
}
