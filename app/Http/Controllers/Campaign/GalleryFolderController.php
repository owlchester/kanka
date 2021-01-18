<?php


namespace App\Http\Controllers\Campaign;


use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\GalleryImageFolderStore;
use App\Services\Campaign\GalleryService;

class GalleryFolderController extends Controller
{
    /** @var GalleryService */
    protected $service;

    public function __construct(GalleryService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.superboosted');

        $this->service = $service;
    }

    public function store(GalleryImageFolderStore $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $folder = $this->service
            ->campaign($campaign)
            ->createFolder($request);

        return redirect()
            ->route('campaign.gallery.index')
            ->withSuccess(__('campaign/gallery.folders.create.success', ['name' => $folder->name]));
    }

}
