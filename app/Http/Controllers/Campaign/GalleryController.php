<?php


namespace App\Http\Controllers\Campaign;


use App\Facades\CampaignLocalization;
use App\Facades\Img;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\GalleryImageFolderStore;
use App\Http\Requests\Campaigns\GalleryImageStore;
use App\Http\Requests\Campaigns\GalleryImageUpdate;
use App\Models\Image;
use App\Services\Campaign\GalleryService;

class GalleryController extends Controller
{
    /** @var GalleryService */
    protected $service;

    public function __construct(GalleryService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.superboosted');

        $this->service = $service;
    }

    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
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

        return view('gallery.index', compact('campaign', 'images', 'folder'));
    }

    public function search()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('gallery', $campaign);

        $name = trim(request()->get('q', null));
        $images = Image::where('name', 'like', "%$name%")
            ->defaultOrder()
            ->take(50)
            ->get();

        return view('gallery.images', compact(
            'images'
        ));
    }

    public function store(GalleryImageStore $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('gallery', $campaign);

        $image = $this->service
            ->campaign($campaign)
            ->store($request);

        $body = view('gallery._image')->with('image', $image)->render();

        return response()->json([
            'success' => true,
            'html' => $body
        ]);
    }

    public function ajaxUpload(GalleryImageStore $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('gallery', $campaign);

        $image = $this->service
            ->campaign($campaign)
            ->store($request);

        return response()->json(Img::resetCrop()->url($image->path));
    }

    /**
     * @param Image $image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Image $image)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('gallery', $campaign);

        $folders = $this->service->campaign($campaign)->folderList();

        return view('gallery.edit', compact('image', 'folders'));
    }

    /**
     * @param GalleryImageUpdate $request
     * @param Image $image
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(GalleryImageUpdate $request, Image $image)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('gallery', $campaign);

        $originalFolderID = $image->folder_id;
        $this->service
            ->campaign($campaign)
            ->image($image)
            ->update($request->only('name', 'folder_id', 'visibility_id'));

        $params = null;
        if ($image->is_folder) {
            $params = ['folder_id' => $image->id];
        } elseif ($originalFolderID != $image->folder_id) {
            $params = ['folder_id' => $originalFolderID];
        } elseif (!empty($image->folder_id)) {
            $params = ['folder_id' => $image->folder_id];
        }

        return redirect()->route('campaign.gallery.index', $params)
            ->with('success', __('campaigns/gallery.update.success'));
    }

    /**
     * @param Image $image
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Image $image)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('gallery', $campaign);

        $image->delete();

        return redirect()->route('campaign.gallery.index')
            ->with('success', __('campaigns/gallery.destroy.success', ['name' => $image->name]));
    }

    /**
     * Create a new folder
     * @param GalleryImageFolderStore $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function folder(GalleryImageFolderStore $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('gallery', $campaign);

        $folder = $this->service
            ->campaign($campaign)
            ->createFolder($request);

        $params = null;
        if (!empty($folder->folder_id)) {
            $params = ['folder_id' => $folder->folder_id];
        }

        return redirect()
            ->route('campaign.gallery.index', $params);
    }
}
