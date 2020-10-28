<?php

namespace App\Http\Controllers\Admin;

use App\Facades\CampaignLocalization;
use App\Facades\EntityPermission;
use App\Http\Controllers\Controller;
use App\Services\FilterService;
use App\Services\PermissionService;
use Arrilot\Widgets\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LogicException;

/**
 * Class AdminCrudController
 * @package App\Http\Controllers\Admin
 */
class AdminCrudController extends Controller
{
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
     * The translation key for the resource
     *
     * @var string
     */
    protected $trans = '';

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
     * If the create index action button is available
     * @var bool
     */
    public $createAction = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('moderator');

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
        $model = new $this->model;
        $this->filterService->make($this->view, request()->all(), $model);
        $name = $this->view;
        $actions = $this->indexActions;
        $filters = $this->filters;
        $filterService = $this->filterService;
        $route = $this->route;
        $trans = $this->trans;
        $createAction = $this->createAction;

        $models = $model
            ->preparedWith()
            ->search(request()->get('search'))
            ->filter($this->filterService->filters())
            ->order($this->filterService->order())
            ->admin()
            ->paginate();

        return view('admin.cruds.index', compact(
            'models',
            'name',
            'trans',
            'model',
            'actions',
            'createAction',
            'filters',
            'filterService',
            'route'
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
        $params['ajax'] = request()->ajax();
        $params['route'] = $this->route;
        $params['trans'] = $this->trans;

        return view('admin.cruds.create', array_merge(['name' => $this->view], $params));
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
        try {
            $model = new $this->model;
            $new = $model->create($request->all());

            $success = trans($this->trans . '.create.success', [
                'name' => link_to_route(
                    $this->route . '.index',
                    e($new->name),
                    $new
                )
            ]);

            if ($redirectToCreated) {
                return redirect()->route($this->route . '.show', $new)
                    ->with('success_raw', $success);
            }
            return redirect()->route($this->route . '.index')
                ->with('success_raw', $success);
        } catch (LogicException $exception) {
            dd($exception);
            $error =  str_replace(' ', '_', strtolower($exception->getMessage()));
            return redirect()->back()->withInput()->with('error', trans('crud.errors.' . $error));
        }
    }

    /**
     * @param Model $model
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function crudShow(Model $model, array $with = [])
    {
        return view('admin.cruds.show', array_merge([
            'model' => $model,
            'view' => $this->view,
            'trans' => $this->trans,
            'route' => $this->route,
        ], $with));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function crudEdit(Model $model)
    {
        $name = $this->view;
        $ajax = request()->ajax();
        $route = $this->route;
        $trans = $this->trans;

        return view('admin.cruds.edit', compact('model', 'name', 'ajax', 'route', 'trans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $character
     * @param  array $fields
     * @return \Illuminate\Http\Response
     */
    public function crudUpdate(Request $request, Model $model, array $fields = [])
    {
        try {
            $model->update(empty($fields) ? $request->all() : $request->only($fields));
            $success = trans($this->trans . '.edit.success', [
                'name' => link_to_route(
                    $this->route . '.index',
                    e($model->name),
                    $model
                )
            ]);

            return redirect()->route($this->route . '.index', $model->id)
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
        return redirect()->route($this->route . '.index')
            ->with('success', trans($this->trans . '.destroy.success', ['name' => $model->name]));
    }
}
