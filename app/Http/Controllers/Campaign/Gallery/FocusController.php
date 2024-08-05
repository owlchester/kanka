<?php

namespace App\Http\Controllers\Campaign\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageFocus;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Campaign\GalleryService;

class FocusController extends Controller
{
    protected GalleryService $service;

    public function __construct(GalleryService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index(Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        $folders = $this->service->campaign($campaign)->folderList();
        return view('gallery.file.focus.edit', compact('image', 'folders', 'campaign'));
    }

    public function save(StoreImageFocus $request, Campaign $campaign, Image $image)
    {
        $this->authorize('gallery', $campaign);

        $added = $this->service
            ->campaign($campaign)
            ->image($image)
            ->user(auth()->user())
            ->saveFocusPoint($request);

        $params = [];
        if (!empty($image->folder_id)) {
            $params = ['folder_id' => $image->folder_id];
        }

        return redirect()->route('gallery', [$campaign] + $params)
            ->with('success', __('campaigns/gallery.focus.' . ($added ? 'updated' : 'removed')));
    }
}
