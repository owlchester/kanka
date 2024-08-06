<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\GalleryImageFolderStore;
use App\Models\Campaign;
use App\Services\Campaign\GalleryService;

class GalleryFolderController extends Controller
{
    protected GalleryService $service;

    public function __construct(GalleryService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function store(GalleryImageFolderStore $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $folder = $this->service
            ->campaign($campaign)
            ->createFolder($request);

        return redirect()
            ->route('gallery', $campaign)
            ->withSuccess(__('campaign/gallery.folders.create.success', ['name' => $folder->name]));
    }
}
