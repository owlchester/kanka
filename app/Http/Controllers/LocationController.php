<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreLocation;
use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class LocationController extends CrudController
{
    /**
     * @var string
     */
    protected $view = 'locations';
    protected $route = 'locations';

    /**
     * @var string
     */
    protected $model = \App\Models\Location::class;

    /**
     * @var LocationService
     */
    protected $locationService;

    /**
     * LocationController constructor.
     */
    public function __construct(LocationService $locationService)
    {
        parent::__construct();

        $this->locationService = $locationService;

        $this->indexActions[] = [
            'route' => route('locations.tree'),
            'class' => 'default',
            'label' => '<i class="fa fa-tree"></i> ' . trans('locations.index.actions.explore_view')
        ];

        $this->filters = [
            'name',
            'type',
            [
                'field' => 'parent_location_id',
                'label' => trans('crud.fields.location'),
                'type' => 'select2',
                'route' => route('locations.find'),
                'placeholder' =>  trans('crud.placeholders.location'),
                'model' => Location::class,
            ]
        ];
    }

    public function tree(Request $request)
    {
        $model = new $this->model;
        $name = $this->view;
        $actions = $this->indexActions;
        $filters = $this->filters;

        $actions = [[
            'route' => route('locations.index'),
            'class' => 'default',
            'label' => '<i class="fa fa-list"></i> ' . trans('locations.index.title')
        ]];

        $search = $model
            ->acl(Auth::user())
            ->filter(request()->all())
            ->search(request()->get('search'))
            ->order(request()->get('order'), request()->has('desc'));

        if (request()->has('parent_location_id')) {
            $search = $search->where(['parent_location_id' => request()->get('parent_location_id')]);
            // Go back
            $actions[] = [
                'route' => redirect()->back()->getTargetUrl(),
                'class' => 'default',
                'label' => '<i class="fa fa-arrow-left"></i> ' . trans('crud.actions.back')
            ];
        } else {
            $search = $search->whereNull('parent_location_id');
        }
        $models = $search
            ->paginate();
        return view('locations.tree', compact('models', 'name', 'model', 'actions', 'filters'));
    }

    /**
     * @param Location $location
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function map(Location $location, Request $request)
    {
        $this->authorize('update', $location);

        if ($request->isMethod('post')) {

            //dd($request->all());
            $this->locationService->managePoints($location, $request->only('map_point'));

            return redirect()->route('locations.show', [$location, '#map'])
                ->with('success', trans('locations.map.success'));
        }
        return view('locations.map', compact('location'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocation $request)
    {
        return $this->crudStore($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return $this->crudShow($location);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Character  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return $this->crudEdit($location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Character  $location
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLocation $request, Location $location)
    {
        return $this->crudUpdate($request, $location);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Character  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        return $this->crudDestroy($location);
    }
}
