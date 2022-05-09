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
}
