<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
