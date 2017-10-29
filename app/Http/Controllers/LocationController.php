<?php

namespace App\Http\Controllers;

use App\Character;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreLocation;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class LocationController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'locations';

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
        $models = Location::with('parentLocation')->search(request()->get('search'))->paginate();
        return view($this->view . '.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->view . '.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocation $request)
    {
        $location = Location::create($request->all());
        return redirect()->route($this->view . '.show', $location->id)->with('success', 'Character created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return view($this->view . '.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        return view($this->view . '.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLocation $request, Location $location)
    {
        $location->update($request->all());
        return redirect()->route($this->view . '.show', $location->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        // Delete
    }
}
