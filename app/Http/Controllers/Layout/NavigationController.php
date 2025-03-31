<?php

namespace App\Http\Controllers\Layout;

use App\Http\Controllers\Controller;
use App\Services\Layout\NavigationService;

class NavigationController extends Controller
{
    public function __construct(protected NavigationService $navigationService)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = $this->navigationService
            ->user(auth()->user())
            ->data();

        return response()->json(
            $data
        );
    }
}
