<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignCache;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Http\Response;

class CssController extends Controller
{
    /**
     * Get the campaign css
     * @return Response
     */
    public function index(Campaign $campaign)
    {
        $css = null;
        if ($campaign->boosted()) {
            $css = CampaignCache::styles();
        }

        $response = \Illuminate\Support\Facades\Response::make($css);
        $response->header('Content-Type', 'text/css');
        $response->header('Expires', Carbon::now()->addMonth()->toDateTimeString());
        $month = 2592000;
        $response->header('Cache-Control', 'public, max_age=' . $month);

        return $response;
    }
}
