<?php

namespace App\Http\Controllers;

use App\Datagrids\Actions\RelationDatagridActions;
use App\Datagrids\Filters\RelationFilter;
use App\Http\Requests\StoreRelation;
use App\Renderers\DatagridRenderer;
use App\Services\AttributeService;
use App\Services\Entity\RelationService;
use App\Models\Campaign;
use App\Models\Relation;
use App\Services\FilterService;

class RelationController extends CrudController
{
    protected RelationService $relationService;

    protected string $view = 'relations';
    protected string $route = 'relations';
    protected $langKey = 'entities/relations';

    protected bool $tabPermissions = false;
    protected bool $tabAttributes = false;
    protected bool $tabBoosted = false;
    protected bool $tabCopy = false;

    protected string $forceMode = 'table';

    protected string $model = Relation::class;

    /** @var string The datagrid controlling the bulk actions */
    protected string $datagridActions = RelationDatagridActions::class;

    /** @var string Disable the sanitizer, handled by the observer */
    protected string $sanitizer = '';

    protected string $filter = RelationFilter::class;


    public function __construct(FilterService $filterService, DatagridRenderer $datagridRenderer, AttributeService $attributeService, RelationService $relationService)
    {
        $this->middleware('auth');
        $this->filterService = $filterService;
        $this->datagrid = $datagridRenderer;
        $this->attributeService = $attributeService;
        $this->relationService = $relationService;
    }

    public function titleKey(): string
    {
        return __('sidebar.relations');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('relations', $campaign);

        $model = new $this->model();

        $params['campaign'] = $campaign;
        $params['entityAttributeTemplates'] = [];
        $params['source'] = null;
        $params['langKey'] = $this->langKey;

        return view('entities.pages.relations.full-form.create', array_merge(['name' => $this->view], $params));
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRelation $request, Campaign $campaign)
    {
        $this->authorize('relations', $campaign);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        try {
            $this->relationService->campaign($campaign)->createRelations($request);
            $new = $this->relationService->getNew();
            $count = $this->relationService->getCount();

            $success = trans_choice($this->langKey . '.create.success_bulk', $count, [
                'entity' => '<a href="' . $new->owner->url() . '">' . $new->owner->name . '</a>',
                'count' => $count,
            ]);
            session()->flash('success_raw', $success);

            if ($request->has('submit-new')) {
                $route = route($this->route . '.create', $campaign);
                return response()->redirectTo($route);
            } elseif ($request->has('submit-update')) {
                $route = route($this->route . '.edit', [$campaign, $new]);
                return response()->redirectTo($route);
            } elseif ($request->has('submit-view')) {
                $route = route($this->route . '.show', [$campaign, $new]);
                return response()->redirectTo($route);
            } elseif ($request->has('submit-copy')) {
                $route = route($this->route . '.create', [$campaign, 'copy' => $new->id]);
                return response()->redirectTo($route);
            } elseif (auth()->user()->new_entity_workflow == 'created') {
                $route = route($this->route . '.show', [$campaign, $new]);
                return response()->redirectTo($route);
            }

            $route = route($this->route . '.index', $campaign);
            return response()->redirectTo($route);
        } catch (\LogicException $exception) {
            $error =  str_replace(' ', '_', mb_strtolower($exception->getMessage()));
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('crud.errors.' . $error));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Campaign $campaign, Relation $relation)
    {
        return redirect()
            ->route('relations.index', $campaign);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, Relation $relation)
    {
        $this->authorize('relations', $campaign);

        $params = [
            'campaign' => $campaign,
            'model' => $relation,
            'relation' => $relation,
            'name' => $this->view,
            'source' => null,
            'langKey' => $this->langKey,
        ];

        return view('entities.pages.relations.full-form.update', $params);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreRelation $request, Campaign $campaign, Relation $relation)
    {
        $this->authorize('relations', $campaign);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->only(['owner_id', 'target_id', 'attitude', 'relation', 'colour', 'is_pinned', 'two_way', 'visibility_id']);
        $relation->update($data);
        $relation->refresh();

        return redirect()
            ->route('relations.index', $campaign)
            ->with('success', __('entities/relations' . '.update.success', [
                'target' => $relation->target->name,
                'entity' => $relation->owner->name
            ]));
    }
}
