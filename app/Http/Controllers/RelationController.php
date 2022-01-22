<?php


namespace App\Http\Controllers;


use App\Datagrids\Filters\RelationFilter;
use App\Datagrids\RelationDatagrid;
use App\Facades\CampaignLocalization;
use App\Facades\FormCopy;
use App\Http\Middleware\Campaign;
use App\Http\Requests\StoreRelation;
use App\Models\Relation;
use Illuminate\Support\Facades\Auth;

class RelationController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'relations';
    protected $route = 'relations';
    protected $langKey = 'entities/relations';

    protected $tabPermissions = false;
    protected $tabAttributes = false;
    protected $tabBoosted = false;
    protected $tabCopy = false;

    protected $bulkTemplates = false;

    /**
     * @var string
     */
    protected $model = \App\Models\Relation::class;

    /**
     * @var string
     */
    protected $datagrid = RelationDatagrid::class;

    /** @var string  */
    protected $filter = RelationFilter::class;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function create()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('relations', $campaign);

        $model = new $this->model;

        $params['ajax'] = request()->ajax();
        $params['tabPermissions'] = false;
        $params['tabAttributes'] = false;
        $params['tabCopy'] = false;
        $params['tabBoosted'] = false;
        $params['entityAttributeTemplates'] = [];
        $params['entityType'] = $model->getEntityType();
        $params['horizontalForm'] = $this->horizontalForm;
        $params['source'] = null;
        $params['langKey'] = $this->langKey;

        return view('entities.pages.relations.full-form.create', array_merge(['name' => $this->view], $params));
    }

    /**
     * @param StoreRelation $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRelation $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('relations', $campaign);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        try {
            $model = new $this->model;
            /** @var Relation $new */
            $new = $model->create($request->all());

            if ($request->has('two_way')) {
                $new->createMirror();
            }

            $success = __($this->langKey . '.create.success', [
                'target' => $new->target->name,
                'entity' => link_to(
                    $new->owner->url(),
                    $new->owner->name
                )
            ]);
            session()->flash('success_raw', $success);

            if ($request->has('submit-new')) {
                $route = route($this->route . '.create');
                return response()->redirectTo($route);
            } elseif ($request->has('submit-update')) {
                $route = route($this->route . '.edit', $new);
                return response()->redirectTo($route);
            } elseif ($request->has('submit-view')) {
                $route = route($this->route . '.show', $new);
                return response()->redirectTo($route);
            } elseif ($request->has('submit-copy')) {
                $route = route($this->route . '.create', ['copy' => $new->id]);
                return response()->redirectTo($route);
            } elseif (auth()->user()->new_entity_workflow == 'created') {
                $route = route($this->route . '.show', $new);
                return response()->redirectTo($route);
            }

            $route = route($this->route . '.index');
            return response()->redirectTo($route);
        } catch (\LogicException $exception) {
            $error =  str_replace(' ', '_', strtolower($exception->getMessage()));
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('crud.errors.' . $error));
        }
    }

    /**
     * @param Relation $relation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Relation $relation)
    {
        return redirect()
            ->route('relations.index');
    }

    /**
     * @param Relation $relation
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Relation $relation)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('relations', $campaign);

        $params = [
            'model' => $relation,
            'relation' => $relation,
            'name' => $this->view,
            'tabPermissions' => false,
            'tabAttributes' => false,
            'tabBoosted' => false,
            'source' => null,
            'tabCopy' => false,
            'entityType' => $relation->getEntityType(),
            'horizontalForm' => $this->horizontalForm,
            'langKey' => $this->langKey,
        ];

        return view('entities.pages.relations.full-form.update', $params);
    }

    /**
     * @param StoreRelation $request
     * @param Relation $relation
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreRelation $request, Relation $relation)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('relations', $campaign);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->only(['owner_id', 'target_id', 'attitude', 'relation', 'colour', 'is_star', 'two_way', 'visibility']);
        $relation->update($data);
        $relation->refresh();

        return redirect()
            ->route('relations.index')
            ->with('success', __('entities/relations' . '.update.success', [
                'target' => $relation->target->name,
                'entity' => $relation->owner->name
            ]));
    }
}
