<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Subscribers\HallOfFameService;

/**
 * Hall of fame - Front facing subscriber list
 */
class HallOfFameController extends Controller
{
    /** @var HallOfFameService */
    protected HallOfFameService $service;

    /**
     * @param HallOfFameService $service
     */
    public function __construct(HallOfFameService $service)
    {
        $this->middleware('fullsetup');
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $subscribers = $this->service->subscribers();
        return view('front.hall_of_fame', compact('subscribers'));
    }
}
