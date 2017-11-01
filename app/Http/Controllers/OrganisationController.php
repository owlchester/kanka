<?php

namespace App\Http\Controllers;

use App\Character;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreOrganisation;
use App\Http\Requests\StoreLocation;
use App\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrganisationController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'organisations';

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
        $models = Organisation::search(request()->get('search'))
            ->order(request()->get('order'))
            ->paginate();
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
    public function store(StoreOrganisation $request)
    {
        Organisation::create($request->all());
        return redirect()->route($this->view . '.index')->with('success', 'Character created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Organisation $organisation)
    {
        return view($this->view . '.show', compact('organisation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organisation $organisation
     * @return \Illuminate\Http\Response
     */
    public function edit(Organisation $organisation)
    {
        return view($this->view . '.edit', compact('organisation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organisation $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrganisation $request, Organisation $organisation)
    {
        $organisation->update($request->all());
        return redirect()->route($this->view . '.show', $organisation->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisation $organisation)
    {
        $organisation->delete();
        return redirect()->route($this->view . '.index')->with('success', 'Organisation removed');
    }
}
