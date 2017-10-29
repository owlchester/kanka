<?php

namespace App\Http\Controllers;

use App\Character;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreLocation;
use App\Family;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FamilyController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'families';

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
        $models = Family::search(request()->get('search'))->paginate();
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
        Family::create($request->all());
        return redirect()->route($this->view . '.index')->with('success', 'Character created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Family $model)
    {
        return view($this->view . '.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Family $model)
    {
        return view($this->view . '.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLocation $request, Family $model)
    {
        $model->update($request->all());
        return redirect()->route($this->view . '.show', $model->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family $model)
    {
        // Delete
    }
}
