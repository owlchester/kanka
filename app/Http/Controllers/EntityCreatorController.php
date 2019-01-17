<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreNote;
use App\Models\Campaign;
use App\Models\MiscModel;
use App\Services\EntityService;

class EntityCreatorController extends Controller
{
    /**
     * @var EntityService
     */
    protected $entityService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntityService $entityService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
        $this->entityService = $entityService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function selection()
    {
        $entities = [];
        /** @var Campaign $campaign */
        $campaign = CampaignLocalization::getCampaign();

        // Loop through the entities, check those enabled in the campaign, and where the user has create access.
        foreach ($this->entityService->entities(['calendars', 'conversations', 'tags', 'dice_rolls', 'menu_links']) as $name => $class) {
            if ($campaign->enabled($name)) {
                if (auth()->user()->can('create', $class)) {
                    $entities[$name] = $class;
                }
            }
        }

        return view('entities.creator.selection', [
            'entities' => $entities
        ]);
    }

    /**
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function form($type)
    {
        // Make sure the user is allowed to create this kind of entity
        $model = $this->entityService->getClass($type);
        $this->authorize('create', $model);

        return view('entities.creator.form', [
            'type' => $type,
            'singularType' => str_singular($type),
            'source' => null,
        ]);
    }

    /**
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store($type)
    {
        // Make sure the user is allowed to create this kind of entity
        $class = $this->entityService->getClass($type);
        $this->authorize('create', $class);

        /** @var StoreNote $request */
        $request = app(StoreNote::class);
        $values = $request->all();

        if (!empty($values['entry'])) {
            $values['entry'] = nl2br($values['entry']);
        }

        /** @var MiscModel $model */
        $model = new $class;
        $new = $model->create($values);

        return response()->json([
            'success' => true,
            'message' => __('entities.creator.success', ['link' => link_to($new->getLink(), e($new->name))])
        ]);
    }
}