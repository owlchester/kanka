<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Services\Api\KbService;
use Carbon\Carbon;

class KbController extends Controller
{
    protected KbService $service;

    public function __construct(KbService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->api())
            ->header('Expires', Carbon::now()->addDays(7)->toDateTimeString());
    }
}
