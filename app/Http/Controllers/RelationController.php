<?php

namespace App\Http\Controllers;

use App\Datagrids\Actions\RelationDatagridActions;
use App\Datagrids\Filters\RelationFilter;
use App\Http\Requests\StoreRelation;
use App\Models\Campaign;
use App\Models\Relation;

class RelationController extends CrudController
{
    protected string $view = 'relations';
    protected string $route = 'relations';
    protected $langKey = 'entities/relations';
    protected string $entityKey = 'relations.';

    protected bool $tabPermissions = false;
    protected bool $tabAttributes = false;
    protected bool $tabBoosted = false;
    protected bool $tabCopy = false;

    protected string $forceMode = 'table';

    /** @var string */
    protected $model = \App\Models\Relation::class;

    /** @var string The datagrid controlling the bulk actions */
    protected string $datagridActions = RelationDatagridActions::class;

    /** @var string Disable the sanitizer, handled by the observer */
    protected string $sanitizer = '';

    /**  */
    protected string $filter = RelationFilter::class;

    public string $titleKey;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');

        $this->titleKey = __('sidebar.relations');
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
        $params['entityType'] = $model->getEntityType();
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
            $count = 0;
            $data = $request->only([
                'owner_id', 'attitude', 'relation', 'colour', 'is_pinned', 'two_way', 'visibility_id'
            ]);
            $data['campaign_id'] = $campaign->id;

            if ($request->has('targets')) {
                $entities = $request->get('targets');
            } else {
                $entities = [$request->get('target_id')];
            }
            foreach ($entities as $entity_id) {
                $data['target_id'] = $entity_id;
                $model = new $this->model();
                /** @var Relation $relation */
                $relation = $model->create($data);
                $count++;
                if (!isset($new)) {
                    $new = $relation;
                }
                if ($request->has('two_way')) {
                    $relation->createMirror();
                    $count++;
                }
            }

            $success = trans_choice($this->langKey . '.create.success_bulk', $count, [
                'entity' => link_to(
                    $new->owner->url(),
                    $new->owner->name
                ),
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
            'entityType' => $relation->getEntityType(),
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
