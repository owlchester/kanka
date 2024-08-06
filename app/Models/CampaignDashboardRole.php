<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CampaignDashboardRole
 * @package App\Models
 *
 * @property int $id
 * @property bool|int $is_default
 * @property bool|int $is_visible
 * @property int $campaign_role_id
 * @property int $campaign_dashboard_id
 *
 * @property CampaignDashboard $dashboard
 * @property CampaignRole $role
 */
class CampaignDashboardRole extends Model
{
    public $fillable = [
        'is_default',
        'is_visible',
        'campaign_role_id',
        'campaign_dashboard_id'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(CampaignRole::class, 'campaign_role_id', 'id');
    }

    public function dashboard(): BelongsTo
    {
        return $this->belongsTo(CampaignDashboard::class, 'campaign_dashboard_id', 'id');
    }
}
