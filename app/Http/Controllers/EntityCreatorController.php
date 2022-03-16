<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Models\MiscModel;
use App\Services\EntityService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
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
    public function store(Request $request, $type)
    {
        // Make sure the user is allowed to create this kind of entity
        $class = $this->entityService->getClass($type);
        $this->authorize('create', $class);

        $names = $request->get('names');
        $values = $request->all();

        // Prepare the data
        unset($values['names']);
        unset($values['_target']);  // Remove target as we need that for something else

        if (!empty($values['entry'])) {
            $values['entry'] = nl2br($values['entry']);
        } elseif ($values['entity'] == 'notes') {
            $values['entry'] = '';
        }

        // Prepare the validator
        /** @var $validator FormRequest */
        $requestValidator = '\App\Http\Requests\Store' . ucfirst(Str::singular($type));
        $validator = new $requestValidator();

        // Now loop on each name and create entities
        $createdEntities = $links = [];
        foreach ($names as $name) {
            if (empty($name)) {
                continue;
            }
            $values['name'] = $name;

            $this->validateEntity($values, $validator->rules());

            /** @var MiscModel $model */
            $model = new $class;
            $new = $model->create($values);
            $new->crudSaved();
            $new->entity->crudSaved();

            $createdEntities[] = $new;
            $links[] = link_to($new->entity->url(), $new->name);
        }

        // If no entity was created, we throw the standard error
        if (empty($createdEntities)) {
            $rules = $validator->rules();
            $this->validateEntity($values, $rules);
        }

        // Content for the selector
        $entities = $this->availableEntities();

        // Have a target? Return json for the js to handle it instead
        if ($request->has('_target')) {
            $first = $createdEntities[0];
            return response()->json([
                '_target' => $request->get('_target'),
                '_id' => $first->id,
                '_name' => $first->name,
            ]);
        }

        return view('entities.creator.selection', [
            'entities' => $entities,
            'new' => trans_choice('entities.creator.success_multiple', count($links), ['link' => implode(', ', $links)])
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

    protected function validateEntity(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        return $this->getValidationFactory()->make(
            $data, $rules, $messages, $customAttributes
        )->validate();
    }
}
