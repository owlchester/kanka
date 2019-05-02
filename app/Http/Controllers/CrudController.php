<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Facades\EntityPermission;
use App\Models\MiscModel;
use App\Services\FilterService;
use App\Traits\GuestAuthTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LogicException;

class CrudController extends Controller
{
    use GuestAuthTrait;

    /**
     * The view where to find the resources
     *
     * @var string
     */
    protected $view = '';

    /**
     * The name of the route for the resource
     *
     * @var string
     */
    protected $route = '';

    /**
     * @var Model
     */
    protected $model = null;

    /**
     * Extra actions in the index view
     *
     * @var array
     */
    protected $indexActions = [];

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var FilterService
     */
    protected $filterService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('campaign.member');

        $this->filterService = new FilterService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->crudIndex($request);
    }
    public function crudIndex(Request $request)
    {
        //$this->authorize('browse', $this->model);

        // Add the is_private filter only for admins.
        if (Auth::check() && Auth::user()->isAdmin()) {
            $this->filters[] = 'is_private';
        }

        $model = new $this->model;
        $this->filterService->prepare($this->view, request()->all(), $model->filterableColumns());
        $name = $this->view;
        $actions = $this->indexActions;
        $filters = $this->filters;
        $filterService = $this->filterService;
        $nestedView = method_exists($this, 'tree');
        $route = $this->route;

        $base = $model
            ->preparedWith()
            ->search(request()->get('search'))
            ->acl()
            ->order($this->filterService->order())
        ;
        $unfilteredCount = $base->count();
        $base = $base->filter($this->filterService->filters());
        $filteredCount =  $base->count();
        $models = $base->paginate();

        return view('cruds.index', compact(
            'models',
            'name',
            'model',
            'actions',
            'filters',
            'filterService',
            'nestedView',
            'route',
            'filteredCount',
            'unfilteredCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->crudCreate();
    }
    public function crudCreate($params = [])
    {
        $this->authorize('create', $this->model);

        if (!isset($params['source'])) {
            $copyId = request()->input('copy');
            if (!empty($copyId)) {
                $model = new $this->model;
                $params['source'] = $model->findOrFail($copyId);
            } else {
                $params['source'] = null;
            }
        }
        $params['ajax'] = request()->ajax();

        return view('cruds.forms.create', array_merge(['name' => $this->view], $params));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param bool $redirectToCreated
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crudStore(Request $request, $redirectToCreated = false)
    {
        $this->authorize('create', $this->model);

        try {
            $model = new $this->model;
            $new = $model->create($request->all());

            // Fire an event for the Entity Observer.
            $new->crudSaved();

            // MenuLink have no entity attached to them.
            if ($new->entity) {
                $new->entity->crudSaved();
            }

            $success = trans($this->view . '.create.success', [
                'name' => link_to_route(
                    $this->view . '.show',
                    e($new->name),
                    $new
                )
            ]);
            if ($request->has('submit-new')) {
                return redirect()->route($this->route . '.create')
                    ->with('success_raw', $success);
            } elseif ($request->has('submit-update')) {
                return redirect()->route($this->route . '.edit', $new)
                    ->with('success_raw', $success);
            } elseif ($request->has('submit-view')) {
                return redirect()->route($this->route . '.show', $new)
                    ->with('success_raw', $success);
            }

            if ($redirectToCreated) {
                return redirect()->route($this->route . '.show', $new)
                    ->with('success_raw', $success);
            }

            $subroute = 'index';
            if (auth()->user()->defaultNested and \Illuminate\Support\Facades\Route::has($this->route . '.tree')) {
                $subroute = 'tree';
            }
            return redirect()->route($this->route . '.' . $subroute)
                ->with('success_raw', $success);
        } catch (LogicException $exception) {
            $error =  str_replace(' ', '_', strtolower($exception->getMessage()));
            return redirect()->back()->withInput()->with('error', trans('crud.errors.' . $error));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudShow(Model $model)
    {
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $model);
        } else {
            $this->authorizeForGuest('read', $model);
        }
        $name = $this->view;
        $ajax = request()->ajax();

        // Fix for models without an entity
        if (empty($model->entity)) {
            $model->save();
            $model->load('entity');
        }

        return view(
            'cruds.show',
            compact('model', 'name', 'permissions', 'ajax')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudEdit(Model $model)
    {
        $this->authorize('update', $model);
        $name = $this->view;
        $ajax = request()->ajax();

        return view('cruds.forms.edit', compact('model', 'name', 'ajax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudUpdate(Request $request, Model $model)
    {
        $this->authorize('update', $model);

        try {
            $data = $this->prepareData($request, $model);
            $model->update($data);

            // Fire an event for the Entity Observer
            $model->crudSaved();

            // MenuLink have no entity attached to them.
            if ($model->entity) {
                $model->entity->crudSaved();
            }

            $success = trans($this->view . '.edit.success', [
                'name' => link_to_route(
                    $this->route . '.show',
                    e($model->name),
                    $model
                )
            ]);

            if ($request->has('submit-new')) {
                return redirect()->route($this->route . '.create')
                    ->with('success_raw', $success);
            } elseif ($request->has('submit-update')) {
                return redirect()->route($this->route . '.edit', $model->id)
                    ->with('success_raw', $success);
            } elseif ($request->has('submit-close')) {
                $subroute = 'index';
                if (auth()->user()->defaultNested and \Illuminate\Support\Facades\Route::has($this->route . '.tree')) {
                    $subroute = 'tree';
                }
                return redirect()->route($this->route . '.' . $subroute)
                    ->with('success_raw', $success);
            }
            return redirect()->route($this->route . '.show', $model->id)
                ->with('success_raw', $success);
        } catch (LogicException $exception) {
            $error =  str_replace(' ', '_', strtolower($exception->getMessage()));
            return redirect()->back()->withInput()->with('error', trans('crud.errors.' . $error));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudDestroy(Model $model)
    {
        $this->authorize('delete', $model);

        $model->delete();

        $subroute = 'index';
        if (auth()->user()->defaultNested and \Illuminate\Support\Facades\Route::has($this->route . '.tree')) {
            $subroute = 'tree';
        }

        return redirect()->route($this->route . '.' . $subroute)
            ->with('success', trans($this->view . '.destroy.success', ['name' => $model->name]));
    }

    /**
     * Multiple delete of a model
     *
     * @param Request $request
     */
    public function deleteMany(Request $request)
    {
        $model = new $this->model;
        $ids = $request->get('model');

        $count = 0;
        foreach ($ids as $id) {
            $entity = $model->findOrFail($id);
            if ($this->authorize('delete', $entity)) {
                $entity->delete();
                $count++;
            }
        }

        $subroute = 'index';
        if (auth()->user()->defaultNested and \Illuminate\Support\Facades\Route::has($this->route . '.tree')) {
            $subroute = 'tree';
        }

        return redirect()->route($this->route . '.' . $subroute)
            ->with('success', trans_choice('crud.destroy_many.success', $count, ['count' => $count]));
    }

    /**
     * @param $model
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function menuView($model, $view, $directView = false)
    {
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $model);
        } else {
            $this->authorizeForGuest('read', $model);
        }
        $name = $this->view;
        $fullview = $this->view . '.' . $view;
        if ($directView) {
            $fullview = 'cruds.subpage.' . $view;
        }

        $data = $model
            ->entity
            ->targetMapPoints()
            ->acl()
            ->orderBy('name', 'ASC')
            ->with(['location'])
            ->paginate();

        return view('cruds.subview', compact(
            'fullview',
            'model',
            'name',
            'data'
        ));
    }

    /**
     * @param Request $request
     * @param MiscModel $model
     * @return array
     */
    protected function prepareData(Request $request, MiscModel $model)
    {
        $data = $request->all();
        foreach ($model->nullableForeignKeys as $field) {
            if (!request()->has($field) && !isset($data[$field])) {
                $data[$field] = null;
            }
        }
        return $data;
    }
}
