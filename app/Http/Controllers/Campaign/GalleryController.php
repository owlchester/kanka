<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\GalleryImageStore;
use App\Http\Requests\Campaigns\GalleryImageUpdate;
use App\Models\Campaign;
use App\Models\Image;
use App\Services\Campaign\GalleryService;

class GalleryController extends Controller
{
    protected GalleryService $service;

    public function __construct(GalleryService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        $folder = null;
        $folderId = request()->get('folder_id');
        if (!empty($folderId)) {
            $folder = Image::where('is_folder', '1')->where('id', $folderId)->firstOrFail();
        }

        $images = $campaign->images()->with('user')
            ->imageFolder($folderId)
            ->defaultOrder()
            ->paginate(50);

        return view('gallery.index', compact('campaign', 'images', 'folder'))
            ->with('galleryService', $this->service->campaign($campaign));
    }

    public function show(Campaign $campaign)
    {
        return redirect()->route('gallery', $campaign);
    }

    /**
     * Uploading multiple images in the gallery
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(GalleryImageStore $request, Campaign $campaign)
    {
        $this->authorize('create', [Image::class, $campaign]);

        $images = $this->service
            ->campaign($campaign)
            ->user(auth()->user())
            ->store($request);

        $body = [];
        foreach ($images as $image) {
            $body[] = view('gallery._image')
                ->with('campaign', $campaign)
                ->with('image', $image)
                ->render();
        }

        return response()->json([
            'success' => true,
            'images' => $body,
            'campaign' => $campaign,
            'storage' => $this->service->storageInfo(),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Image $image)
    {
        $this->authorize('view', [$image, $campaign]);

        $folders = $this->service->campaign($campaign)->folderList();

        return view('gallery.file.edit', compact('image', 'folders', 'campaign'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(GalleryImageUpdate $request, Campaign $campaign, Image $image)
    {
        $this->authorize('edit', [$image, $campaign]);

        $originalFolderID = $image->folder_id;
        $this->service
            ->campaign($campaign)
            ->image($image)
            ->update($request->only('name', 'folder_id', 'visibility_id'));

        $params = [];
        if ($image->is_folder) {
            $params = ['folder_id' => $image->id];
        } elseif ($originalFolderID != $image->folder_id) {
            $params = ['folder_id' => $originalFolderID];
        } elseif (!empty($image->folder_id)) {
            $params = ['folder_id' => $image->folder_id];
        }
        $params['campaign'] = $campaign;

        $key = $image->isFolder() ? 'folder' : 'success';
        return redirect()->route('gallery', $params)
            ->with('success', __('campaigns/gallery.update.' . $key));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Image $image)
    {
        $this->authorize('delete', [$image, $campaign]);

        $options = [$campaign];
        if ($image->folder_id) {
            $options['folder_id'] = $image->folder_id;
        }
        $this->service->campaign($campaign)->image($image)->delete();

        $key = $image->isFolder() ? 'folder' : 'success';
        return redirect()->route('gallery', $options)
            ->with('success', __('campaigns/gallery.destroy.' . $key, ['name' => $image->name]));
    }
}
