<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\UpdateFile;
use App\Http\Requests\Gallery\UpdateFocus;
use App\Http\Resources\GalleryFile;
use App\Http\Resources\GalleryFileFull;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Gallery\MoveService;

class UpdateController extends Controller
{
    protected MoveService $service;

    public function __construct(MoveService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function process(UpdateFile $request, Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        $image->update(
            $request->only(['name', 'visibility_id'])
        );

        return (new GalleryFile($image))->campaign($campaign);
    }

    public function focus(UpdateFocus $request, Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        $image->update(
            $request->only(['focus_x', 'focus_y'])
        );

        return (new GalleryFile($image))->campaign($campaign);
    }
}
