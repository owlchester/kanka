<?php

namespace App\Http\Controllers\Layout;

use App\Http\Controllers\Controller;
use App\Services\Layout\NavigationService;

class NavigationController extends Controller
{
    protected NavigationService $service;

    public function __construct(NavigationService $navigationService)
    {
        $this->service = $navigationService;
        $this->middleware('auth');
    }

    public function index()
    {
        $data = $this->service
            ->user(auth()->user())
            ->data();

        return response()->json(
            $data
        );
    }
}
