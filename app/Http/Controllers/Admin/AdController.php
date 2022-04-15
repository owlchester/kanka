<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreAd;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends AdminCrudController
{
    /**
     * @var string
     */
    protected $view = 'admin.ads';
    protected $route = 'admin.ads';
    protected $trans = 'admin/ads';

    /**
     * @var string
     */
    protected $model = \App\Models\Ad::class;

    /**
     * CharacterController constructor.
     */
    public function __construct()
    {
        $this->filters = [
            'customer',
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
            ->with('updater')
            ->orderByDesc('is_active')
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
    public function store(StoreAd $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        return $this->crudEdit($ad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAd $request, Ad $ad)
    {
        return $this->crudUpdate($request, $ad, []);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();

        return redirect()->route($this->route . '.index')
            ->with('success', trans($this->trans . '.destroy.success', ['name' => $ad->name]));

    }
}
