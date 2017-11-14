<?php

namespace App\Http\Controllers;

use App\Location;
use App\Models\LocationRelation;
use App\Http\Requests\StoreLocation;
use App\Http\Requests\StoreLocationRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocationRelationController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'locations.relations';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = LocationRelation::paginate();
        return view($this->view . '.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location = Location::findOrFail(request()->get('location'));
        return view($this->view . '.create', compact('location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationRelation $request)
    {
        $relation = LocationRelation::create($request->all());
        return redirect()->route('locations.show', [$relation->first_id, 'tab' => 'relation'])
            ->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(LocationRelation $locationRelation)
    {
        return view($this->view . '.show', compact('locationRelation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(LocationRelation $locationRelation)
    {
        return view($this->view . '.edit', compact('locationRelation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLocationRelation $request, LocationRelation $locationRelation)
    {
        $locationRelation->update($request->all());
        return redirect()->route('locations.show', $locationRelation->first_id)
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LocationRelation  $locationRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(LocationRelation $locationRelation)
    {
        $locationRelation->delete();
        return redirect()->route('locations.show', [$locationRelation->first_id, 'tab' => 'relation'])
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
