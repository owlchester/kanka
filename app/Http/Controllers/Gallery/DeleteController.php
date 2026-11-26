<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\DeleteImages;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Gallery\DeleteService;
use App\Services\Gallery\StorageService;

class DeleteController extends Controller
{
    protected DeleteService $service;

    protected StorageService $storage;

    public function __construct(DeleteService $service, StorageService $storageService)
    {
        $this->middleware('auth');
        $this->service = $service;
        $this->storage = $storageService;
    }

    public function preview(Campaign $campaign, DeleteImages $request)
    {
        $this->authorize('gallery', $campaign);

        $preview = $this->service
            ->campaign($campaign)
            ->user($request->user())
            ->preview($request->validated('images'));

        return response()->json($preview);
    }

    public function destroy(Campaign $campaign, DeleteImages $request)
    {
        $this->authorize('gallery', $campaign);

        $count = $this->service
            ->campaign($campaign)
            ->user($request->user())
            ->delete($request->validated('images'));

        $this->storage->campaign($campaign)->clearCache();

        return response()->json([
            'toast' => trans_choice('gallery.delete.success', $count, ['count' => $count]),
            'used' => $this->storage->uncachedUsedSpace(),
        ]);
    }

    public function file(Campaign $campaign, Image $image)
    {
        if ($image->campaign_id !== $campaign->id) {
            abort(404);
        }

        $this->authorize('delete', [$image, $campaign]);

        $image->delete();
        $this->storage->campaign($campaign)->clearCache();

        return response()->json([
            'used' => $this->storage->uncachedUsedSpace(),
        ]);
    }
}
