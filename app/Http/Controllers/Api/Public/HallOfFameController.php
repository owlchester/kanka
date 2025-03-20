<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Services\Subscribers\HallOfFameService;
use Carbon\Carbon;

class HallOfFameController extends Controller
{
    protected HallOfFameService $service;

    public function __construct(HallOfFameService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->subscribers())
            ->header('Expires', Carbon::now()->addDays(1)->toDateTimeString());
    }
}
