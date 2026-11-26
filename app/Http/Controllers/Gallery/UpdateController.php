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
use Illuminate\Validation\ValidationException;

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
            ->user($request->user())
            ->files($request->validated('files'))
            ->update($request->only('visibility_id', 'folder_id', 'folder_home'));

        return response()->json(['toast' => trans_choice('gallery.update.success', $count, ['count' => $count])]);
    }

    public function process(UpdateFile $request, Campaign $campaign, Image $image)
    {
        if ($image->campaign_id !== $campaign->id) {
            abort(404);
        }

        $this->authorize('edit', [$image, $campaign]);

        $data = $request->only(['name', 'description', 'author', 'visibility_id']);

        if ($request->has('folder_id')) {
            $folderId = $request->input('folder_id');
            if ($folderId !== null && $image->isFolder()) {
                $targetFolder = Image::where('id', $folderId)
                    ->where('campaign_id', $campaign->id)
                    ->where('is_folder', true)
                    ->firstOrFail();

                if ($targetFolder->id === $image->id || $targetFolder->isDescendantOf($image->id)) {
                    throw ValidationException::withMessages([
                        'folder_id' => __('gallery.update.errors.folder_cycle'),
                    ]);
                }
            }
            $data['folder_id'] = $folderId;
        }

        $image->update($data);

        return (new GalleryFile($image->fresh(['creator'])))->campaign($campaign);
    }

    public function focus(UpdateFocus $request, Campaign $campaign, Image $image)
    {
        if ($image->campaign_id !== $campaign->id) {
            abort(404);
        }

        $this->authorize('edit', [$image, $campaign]);

        $image->update(
            $request->only(['focus_x', 'focus_y'])
        );

        return (new GalleryFile($image->fresh(['creator'])))->campaign($campaign);
    }
}
