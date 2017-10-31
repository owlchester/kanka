<?php

namespace App\Services;

use App\Campaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CampaignService
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Campaign
     */
    protected $campaign;

    /**
     * CampaignService constructor.
     */
    public function __construct()
    {
        $this->id = Session::get('campaign_id');
        $this->campaign = Campaign::where('id', $this->id)->first();
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->campaign->name;
    }

    /**
     * @param $id
     */
    public static function switchCampaign($id)
    {
        Session::put('campaign_id', $id);
        $user = Auth::user();
        $user->last_campaign_id = $id;
        $user->save();
    }
}
