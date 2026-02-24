<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Services\Api\ShowcaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShowcaseController extends Controller
{
    public function __construct(protected ShowcaseService $service) {}

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

    public function setup(Request $request)
    {
        return response()
            ->json(
                $this->service
                    ->request($request)
                    ->search()
            )
            ->header('Expires', Carbon::now()->addDays(1)->toDateTimeString());
    }
}
