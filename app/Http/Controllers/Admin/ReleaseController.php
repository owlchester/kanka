<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreRelease;
use App\Models\AppRelease;
use Illuminate\Http\Request;

class ReleaseController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.releases';
    protected $route = 'admin.app-releases';
    protected $trans = 'admin/releases';

    /**
     * @var string
     */
    protected $model = \App\Models\AppRelease::class;

    /**
     * CharacterController constructor.
     */
    public function __construct()
    {
        $this->filters = [
            'name',
        ];

        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $model = new $this->model;
        $name = $this->view;
        $actions = $this->indexActions;
        $route = $this->route;
        $trans = $this->trans;
        $createAction = $this->createAction;
        $this->filterService->make($this->view, request()->all(), $model);
        $filterService = $this->filterService;

        $models = $model
            ->filter(request()->all())
            ->search($filterService->search())
            ->paginate();
        return view('admin.cruds.index', compact(
            'models',
            'name',
            'model',
            'actions',
            'createAction',
            'route',
            'filterService',
            'trans'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRelease $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AppRelease $appRelease
     * @return \Illuminate\Http\Response
     */
    public function edit(AppRelease $appRelease)
    {
        return $this->crudEdit($appRelease);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AppRelease  $appRelease
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRelease $request, AppRelease $appRelease)
    {
        return $this->crudUpdate($request, $appRelease, []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AppRelease $appRelease
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppRelease $appRelease)
    {
        $appRelease->delete();

        return redirect()->route($this->route . '.index')
            ->with('success', trans($this->trans . '.destroy.success', ['name' => $release->name]));

    }
}
