<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\UpdateFile;
use App\Http\Requests\Gallery\UpdateFiles;
use App\Http\Requests\Gallery\UpdateFocus;
use App\Http\Resources\GalleryFile;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Gallery\UpdateService;

class UpdateController extends Controller
{
    protected UpdateService $service;

    public function __construct(UpdateService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function bulk(UpdateFiles $request, Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        $count = $this->service
            ->campaign($campaign)
            ->files($request->get('files'))
            ->update($request->only('visibility_id', 'folder_id', 'folder_home'));

        return response()->json(['toast' => trans_choice('gallery.update.success', $count, ['count' => $count])]);
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
