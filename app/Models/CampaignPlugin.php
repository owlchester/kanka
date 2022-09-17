<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CampaignPlugin
 * @package App\Models
 *
 * @property int $campaign_id
 * @property int $created_by
 * @property int $plugin_id
 * @property int $plugin_version_id
 * @property string $name
 * @property bool $is_active
 * @property Plugin $plugin
 * @property Campaign $campaign
 * @property PluginVersion $version
 *
 * @method Builder|CampaignPlugin templates(Campaign $campaign)
 */
class CampaignPlugin extends Model
{
    public function plugin()
    {
        return $this->belongsTo(Plugin::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function version()
    {
        return $this->belongsTo(PluginVersion::class, 'plugin_version_id');
    }

    public function scopeTemplates(Builder $builder, Campaign $campaign)
    {
        return $builder->leftJoin('plugins as p', 'p.id', 'plugin_id')
            ->where('campaign_id', $campaign->id)
            ->where('p.type_id', 2)
            ->where('is_active', true)
            ->with('version')
            ->orderBy('p.name');
    }

    /**
     * @return bool
     */
    public function canEnable(): bool
    {
        return $this->plugin->isTheme() && !$this->is_active;
    }

    /**
     * @return bool
     */
    public function canDisable(): bool
    {
        return $this->plugin->isTheme() && $this->is_active;
    }

    /**
     * Determine if the plug is renderable. This is needed for character sheets in draft statuses, to only
     * render a sheet for the author, as they can potentially add XSS injections.
     * @return bool
     */
    public function renderable(): bool
    {
        if (!$this->plugin->isAttributeTemplate()) {
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
     * @return bool
     */
    public function isAuthor(): bool
    {
        if (auth()->guest()) {
            return false;
        }
        return $this->plugin->created_by === auth()->user()->id;
    }
}
