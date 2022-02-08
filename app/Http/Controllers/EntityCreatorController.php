<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreNote;
use App\Models\Campaign;
use App\Models\MiscModel;
use App\Services\EntityService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

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
        $entities = $this->availableEntities();
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
        $origin = request()->get('origin');
        $target = request()->get('target');

        return view('entities.creator.form', [
            'type' => $type,
            'singularType' => Str::singular($type),
            'source' => null,
            'origin' => $origin,
            'target' => $target,
        ]);
    }

    /**
     * @param $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function store($type)
    {
        // Make sure the user is allowed to create this kind of entity
        $class = $this->entityService->getClass($type);
        $this->authorize('create', $class);

        /** @var FormRequest $request */
        // This is dirty. Todo: change? We really need a entity -> icon, name, class, validator service somewhere
        $requestValidator = '\App\Http\Requests\Store' . ucfirst(Str::singular($type));
        $request = app($requestValidator);
        $values = $request->all();

        if (!empty($values['entry'])) {
            $values['entry'] = nl2br($values['entry']);
        } elseif ($values['entity'] == 'notes') {
            $values['entry'] = '';
        }

        // Remove target as we need that for something else
        unset($values['_target']);

        /** @var MiscModel $model */
        $model = new $class;
        $new = $model->create($values);
        $new->crudSaved();
        $new->entity->crudSaved();

        // Content for the selector
        $entities = $this->availableEntities();

        // Have a target? Return json for the js to handle it instead
        if ($request->has('_target')) {
            return response()->json([
                '_target' => $request->get('_target'),
                '_id' => $new->id,
                '_name' => $new->name,
            ]);
        }

        return view('entities.creator.selection', [
            'entities' => $entities,
            'new' => __('entities.creator.success', ['link' => link_to($new->getLink(), e($new->name))])
        ]);
    }

    /**
     * Build a list of available entities for the quick creator
     * @return array
     */
    protected function availableEntities(): array
    {

        $entities = [];
        /** @var Campaign $campaign */
        $campaign = CampaignLocalization::getCampaign();

        // Loop through the entities, check those enabled in the campaign, and where the user has create access.
        foreach ($this->entityService->entities([
            'calendars', 'conversations', 'tags', 'dice_rolls', 'menu_links'
        ]) as $name => $class) {
            if ($campaign->enabled($name)) {
                if (auth()->user()->can('create', $class)) {
                    $entities[$name] = $class;
                }
            }
        }

        return $entities;
    }
}
