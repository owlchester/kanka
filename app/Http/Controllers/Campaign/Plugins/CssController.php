<?php

namespace App\Http\Controllers\Campaign\Plugins;

use App\Facades\CampaignCache;
use App\Http\Controllers\Controller;
use App\Models\Campaign;

class CssController extends Controller
{
    public function index(Campaign $campaign)
    {
        $themes = CampaignCache::themes();

        $response = \Illuminate\Support\Facades\Response::make($themes);
        $response->header('Content-Type', 'text/css');
        // $response->header('Expires', Carbon::now()->addMonth()->toDateTimeString());
        $month = 31536000;
        $response->setLastModified($campaign->updated_at->toDateTime());
        $response->header('Cache-Control', 'public, max_age=' . $month);

        return $response;
    }
}
