<?php


namespace App\Facades;


use App\Models\Campaign;
use App\Models\CampaignDashboard;
use App\Models\Entity;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Facade;

/**
 * Class Dashboard
 * @package App\Facades
 *
 * @method static self add(Entity $entity)
 * @method static array excluding()
 * @method static self campaign(Campaign $campaign)
 * @method static null|CampaignDashboard getDashboard(int $dashboard = null)
 * @method static CampaignDashboard[] getDashboards()
 *
 * @see DashboardService
 */
class Dashboard extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dashboard';
    }
}
{

}
