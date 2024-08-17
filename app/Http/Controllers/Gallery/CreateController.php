<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\CreateFolder;
use App\Models\Campaign;
use App\Services\Gallery\CreateService;

class CreateController extends Controller
{
    protected CreateService $service;

    public function __construct(CreateService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index(Campaign $campaign, CreateFolder $request)
    {
        $this->authorize('gallery', $campaign);

        $folder = $this->service
            ->campaign($campaign)
            ->create($request);

        return response()->json(['folder' => $folder]);
    }
}
