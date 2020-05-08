<?php


namespace App\Http\Controllers\Campaign;


use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\DefaultImageDestroy;
use App\Http\Requests\Campaigns\DefaultImageStore;
use App\Services\Campaign\DefaultImageService;
use App\Services\EntityService;

class DefaultImageController extends Controller
{
    /** @var DefaultImageService */
    protected $service;

    /** @var EntityService */
    protected $entityService;

    public function __construct(EntityService $entityService, DefaultImageService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted');

        $this->service = $service;
        $this->entityService = $entityService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);


        return view('campaigns.default-images.index', compact('campaign'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);
        $ajax = request()->ajax();

        $entities = $this->entityService->labelledEntities(false, $campaign->existingDefaultImages());

        return view('campaigns.default-images.create', compact(
            'campaign', 'ajax', 'entities'
        ));

    }

    /**
     * @param DefaultImageStore $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(DefaultImageStore $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);

        if ($this->service->campaign($campaign)->type($request->post('entity_type'))->save($request)) {
            return redirect()->route('campaign.default-images')
                ->with(
                    'success',
                    __('campaigns/default-images.create.success', ['type' => __('entities.' . $request->post('entity_type'))])
                );
        }
        return redirect()->route('campaign.default-images')
            ->with(
                'error',
                __('campaigns/default-images.create.error', ['type' => __('entities.' . $request->post('entity_type'))])
            );
    }

    /**
     * @param DefaultImageDestroy $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DefaultImageDestroy $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);
        $this->service->campaign($campaign)->type($request->post('entity_type'))->destroy();

        return redirect()->route('campaign.default-images')
            ->with(
                'success',
                __('campaigns/default-images.destroy.success', ['type' => __('entities.' . $request->post('entity_type'))])
            );
    }

}
