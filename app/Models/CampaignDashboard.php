<?php


namespace App\Models;


use App\Traits\CampaignTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CampaignDashboard
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property int $created_by
 *
 * @property CampaignDashboardWidget[] $widgets
 * @property CampaignDashboardRole[] $roles
 *
 * @method static Builder|self exclude(CampaignDashboard $campaignDashboard)
 */
class CampaignDashboard extends Model
{
    use CampaignTrait;

    public $fillable = [
        'name',
        'campaign_id',
        'created_by'
    ];

    public function widgets()
    {
        return $this->hasMany(CampaignDashboardWidget::class, 'dashboard_id', 'id');
    }

    public function roles()
    {
        return $this->hasMany(CampaignDashboardRole::class, 'campaign_dashboard_id', 'id');
    }

    /**
     * @param Builder $builder
     * @param CampaignDashboard|null $campaignDashboard
     * @return Builder
     */
    public function scopeExclude(Builder $builder, CampaignDashboard $campaignDashboard = null)
    {
        if (empty($campaignDashboard)) {
            return $builder;
        }

        return $builder->where('id', '!=', $campaignDashboard->id);
    }

    /**
     * Check if a campaign role is set up
     * @param CampaignRole $role
     * @param bool $default
     * @return bool
     */
    public function permission(CampaignRole $role, bool $default = false): bool
    {
        /** @var CampaignDashboardRole $role */
        $dashboardRole = $this->roles->where('campaign_role_id', $role->id)
            ->first();

        if (empty($dashboardRole)) {
            return false;
        }

        if ($default) {
            return $dashboardRole->is_default;
        }
        return $dashboardRole->is_visible;
    }
}
