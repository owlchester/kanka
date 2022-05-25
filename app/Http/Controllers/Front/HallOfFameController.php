<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\PatreonService;

/**
 * Hall of fame - Front facing subscriber list
 */
class HallOfFameController extends Controller
{
    /** @var PatreonService */
    protected $service;

    /**
     * @param PatreonService $service
     */
    public function __construct(PatreonService $service)
    {
        $this->middleware('fullsetup');

        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $patrons = $this->service->patrons();
        return view('front.hall_of_fame', compact('patrons'));
    }
}
