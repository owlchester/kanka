<?php

namespace App\Http\Controllers\Gallery;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\ReplaceFile;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Gallery\ReplaceService;
use App\Services\Gallery\StorageService;

class ReplaceController extends Controller
{
    public function __construct(
        protected ReplaceService $service,
        protected StorageService $storage,
    ) {
        $this->middleware('auth');
    }

    public function store(ReplaceFile $request, Campaign $campaign, Image $image)
    {
        if ($image->campaign_id !== $campaign->id) {
            abort(404);
        }

        $this->authorize('edit', [$image, $campaign]);

        if ($image->isFolder()) {
            return response()->json([
                'error' => __('gallery.replace.errors.folder'),
            ], 422);
        }

        try {
            $resource = $this->service
                ->campaign($campaign)
                ->user($request->user())
                ->replace($image, $request->file('file'));

            return response()->json([
                'data' => $resource,
                'toast' => __('gallery.replace.success'),
                'used' => $this->storage->campaign($campaign)->uncachedUsedSpace(),
            ]);
        } catch (TranslatableException $e) {
            return response()->json([
                'error' => $e->getTranslatedMessage(),
            ], 422);
        }
    }
}
