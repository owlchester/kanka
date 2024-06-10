<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\DefaultImageDestroy;
use App\Http\Requests\Campaigns\DefaultImageStore;
use App\Models\Campaign;
use App\Services\Campaign\DefaultImageService;
use App\Services\Entity\TypeService;

class DefaultImageController extends Controller
{
    protected DefaultImageService $service;

    protected TypeService $typeService;

    public function __construct(TypeService $typeService, DefaultImageService $service)
    {

        $this->service = $service;
        $this->typeService = $typeService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        return view('campaigns.default-images.index', compact('campaign'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        $ignore = $campaign->existingDefaultImages();
        $ignore = array_merge($ignore, ['bookmarks']);
        $entities = $this->typeService
            ->campaign($campaign)
            ->exclude($ignore)
            ->plural()
            ->get()
        ;

        return view('campaigns.default-images.create', compact(
            'campaign',
            'entities'
        ));
    }

    /**
     */
    public function store(DefaultImageStore $request, Campaign $campaign)
    {
        $this->authorize('recover', $campaign);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        if ($this->service->campaign($campaign)->type($request->post('entity_type'))->save($request)) {
            return redirect()->route('campaign.default-images', $campaign)
                ->with(
                    'success',
                    __('campaigns/default-images.create.success', ['type' => __('entities.' . $request->post('entity_type'))])
                );
        }
        return redirect()->route('campaign.default-images', $campaign)
            ->with(
                'error',
                __('campaigns/default-images.create.error', ['type' => __('entities.' . $request->post('entity_type'))])
            );
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DefaultImageDestroy $request, Campaign $campaign)
    {
        $this->authorize('recover', $campaign);
        $this->service
            ->campaign($campaign)
            ->type($request->post('entity_type'))
            ->destroy();

        return redirect()->route('campaign.default-images', $campaign)
            ->with(
                'success',
                __('campaigns/default-images.destroy.success', ['type' => __('entities.' . $request->post('entity_type'))])
            );
    }
}
