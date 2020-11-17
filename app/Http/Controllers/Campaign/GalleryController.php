<?php


namespace App\Http\Controllers\Campaign;


use App\Facades\CampaignLocalization;
use App\Facades\Img;
use App\Http\Controllers\Controller;
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
        $this->authorize('update', $campaign);

        $images = $campaign->images()->with('user')->orderBy('updated_at', 'desc')->paginate(50);

        return view('gallery.index', compact('campaign', 'images'));
    }

    public function search()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $name = trim(request()->get('q', null));
        $images = Image::where('name', 'like', "%$name%")->orderBy('updated_at', 'desc')->take(50)->get();

        return view('gallery.images', compact(
            'images'
        ));
    }

    public function store(GalleryImageStore $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

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
        $this->authorize('update', $campaign);

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
        $this->authorize('update', $campaign);

        return view('gallery.edit', compact('image'));
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
        $this->authorize('update', $campaign);

        $this->service
            ->campaign($campaign)
            ->image($image)
            ->update($request->post('name'));

        return redirect()->route('campaign.gallery.index')
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
        $this->authorize('update', $campaign);

        $image->delete();

        return redirect()->route('campaign.gallery.index')
            ->with('success', __('campaigns/gallery.destroy.success', ['name' => $image->name]));
    }
}
