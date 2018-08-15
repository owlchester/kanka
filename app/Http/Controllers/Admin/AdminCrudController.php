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
        $this->filterService->prepare($this->view, request()->all(), $model->filterableColumns());
        $name = $this->view;
        $actions = $this->indexActions;
        $filters = $this->filters;
        $filterService = $this->filterService;

        $models = $model
            ->preparedWith()
            ->search(request()->get('search'))
            ->filter($this->filterService->filters())
            ->order($this->filterService->order())
            ->admin()
            ->paginate();
        return view('admin.cruds.index', compact('models', 'name', 'model', 'actions', 'filters', 'filterService'));
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
            ->with('success', trans($this->view . '.destroy.success', ['name' => $model->name]));
    }
}
