<?php

namespace App\Http\Controllers;

use App\Organisation;
use App\Models\OrganisationRelation;
use App\Http\Requests\StoreOrganisation;
use App\Http\Requests\StoreOrganisationRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrganisationRelationController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'organisations.relations';
    
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
        $models = OrganisationRelation::paginate();
        return view($this->view . '.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organisation = Organisation::findOrFail(request()->get('organisation'));
        return view($this->view . '.create', compact('organisation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrganisationRelation $request)
    {
        $relation = OrganisationRelation::create($request->all());
        return redirect()->route('organisations.show', [$relation->first_id, 'tab' => 'relation'])
            ->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function show(OrganisationRelation $organisationRelation)
    {
        return view($this->view . '.show', compact('organisationRelation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganisationRelation $organisationRelation)
    {
        return view($this->view . '.edit', compact('organisationRelation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrganisationRelation $request, OrganisationRelation $organisationRelation)
    {
        $organisationRelation->update($request->all());
        return redirect()->route('organisations.show', $organisationRelation->first_id)
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrganisationRelation  $organisationRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganisationRelation $organisationRelation)
    {
        $organisationRelation->delete();
        return redirect()->route('organisations.show', [$organisationRelation->first_id, 'tab' => 'relation'])
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
