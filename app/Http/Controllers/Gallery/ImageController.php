<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Gallery\SetupService;

class ImageController extends Controller
{
    protected SetupService $service;

    public function __construct(SetupService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function show(Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        if ($image->isFolder()) {
            return response()->json(
                $this->service
                    ->user(auth()->user())
                    ->campaign($campaign)
                    ->image($image)
                    ->open()
            );
        }
    }
}
