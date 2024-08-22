<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryFileFull;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Gallery\MoveService;

class ShowController extends Controller
{
    protected MoveService $service;

    public function __construct(MoveService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function show(Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        return new GalleryFileFull($image);
    }

}
