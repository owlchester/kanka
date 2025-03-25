<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Services\Api\CampaignService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    protected CampaignService $service;

    public function __construct(CampaignService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response()
            ->json(
                $this->service
                    ->request($request)
                    ->search()
            )
            ->header('Expires', Carbon::now()->addDays(1)->toDateTimeString());
    }

    public function setup()
    {
        return response()
            ->json(
                $this->service
                    ->setup()
            )
            ->header('Expires', Carbon::now()->addDays(1)->toDateTimeString());
    }
}
