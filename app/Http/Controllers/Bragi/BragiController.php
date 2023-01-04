<?php

namespace App\Http\Controllers\Bragi;

use App\Http\Controllers\Controller;
use App\Http\Requests\BragiRequest;
use App\Services\Bragi\BragiService;

class BragiController extends Controller
{
    protected BragiService $service;

    public function __construct(BragiService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index()
    {
        return response()->json(
            $this->service
                ->user(auth()->user())
                ->prepare()
        );
    }

    public function generate(BragiRequest $request)
    {
        return response()->json(
            $this->service
                ->user(auth()->user())
                ->generate($request)
        );
    }
}
