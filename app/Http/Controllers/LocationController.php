<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreLocation;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * LocationController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->indexActions[] = [
            'route' => route('locations.tree'),
            'class' => 'default',
            'label' => '<i class="fa fa-tree"></i> ' . trans('locations.index.actions.explore_view')
        ];
    }

    public function tree(Request $request)
    {
        $model = new $this->model;
        $name = $this->view;
        $actions = $this->indexActions;

        $actions = [[
            'route' => route('locations.index'),
            'class' => 'default',
            'label' => '<i class="fa fa-list"></i> ' . trans('locations.index.title')
        ]];

        $search = $model
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
        return view('locations.tree', compact('models', 'name', 'model', 'actions'));
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
