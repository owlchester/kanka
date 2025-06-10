<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\DefaultImageDestroy;
use App\Http\Requests\Campaigns\DefaultImageStore;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\Campaign\DefaultImageService;
use App\Services\EntityTypeService;

class DefaultImageController extends Controller
{
    public function __construct(
        protected EntityTypeService $entityTypeService,
        protected DefaultImageService $service
    ) {
        $this->middleware('campaign.boosted', ['except' => 'index']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $entityTypes = [];
        /** @var EntityType $entityType */
        foreach (EntityType::inCampaign($campaign)->get() as $entityType) {
            $entityTypes[$entityType->pluralCode()] = $entityType;
        }

        $images = $campaign->defaultImages();

        return view('campaigns.default-images.index')
            ->with('campaign', $campaign)
            ->with('images', $images)
            ->with('entityTypes', $entityTypes);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        $ignore = $campaign->existingDefaultImages();

        $entityTypes = $this->entityTypeService
            ->campaign($campaign)
            ->exclude(config('entities.ids.bookmark'))
            ->skip($ignore)
            ->toSelect();

        return view('campaigns.default-images.create', compact(
            'campaign',
            'entityTypes'
        ));
    }

    public function store(DefaultImageStore $request, Campaign $campaign)
    {
        $this->authorize('recover', $campaign);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        /** @var EntityType $entityType */
        $entityType = EntityType::inCampaign($campaign)->find($request->post('entity_type'));

        if ($this->service->campaign($campaign)->entityType($entityType)->user(auth()->user())->save($request)) {
            return redirect()->route('campaign.default-images', $campaign)
                ->with(
                    'success',
                    __('campaigns/default-images.create.success', ['type' => $entityType->plural()])
                );
        }

        return redirect()->route('campaign.default-images', $campaign)
            ->with(
                'error',
                __('campaigns/default-images.create.error', ['type' => $entityType->plural()])
            );
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DefaultImageDestroy $request, Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        /** @var EntityType $entityType */
        $entityType = EntityType::inCampaign($campaign)->findOrFail($request->post('entity_type'));
        $this->service
            ->campaign($campaign)
            ->user(auth()->user())
            ->entityType($entityType)
            ->destroy();

        return redirect()->route('campaign.default-images', $campaign)
            ->with(
                'success',
                __('campaigns/default-images.destroy.success', ['type' => $entityType->plural()])
            );
    }
}
