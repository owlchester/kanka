<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryFileFull;
use App\Models\Campaign;
use App\Models\Image;

class ShowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Campaign $campaign, Image $image)
    {
        if ($image->campaign_id !== $campaign->id) {
            abort(404);
        }

        $this->authorize('view', [$image, $campaign]);

        return new GalleryFileFull($image);
    }
}
