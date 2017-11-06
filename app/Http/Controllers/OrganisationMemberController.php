<?php

namespace App\Http\Controllers;

use App\Character;
use App\Organisation;
use App\OrganisationMember;
use App\Http\Requests\StoreCharacter;
use App\Http\Requests\StoreOrganisationMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrganisationMemberController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'organisations.members';
    
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
        $models = OrganisationMember::paginate();
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
    public function store(StoreOrganisationMember $request)
    {
        $relation = OrganisationMember::create($request->all());
        return redirect()->route('organisations.show', [$relation->organisation_id, 'tab' => 'member'])
            ->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(OrganisationMember $organisationMember)
    {
        return view($this->view . '.show', compact('organisationMember'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganisationMember $organisationMember)
    {
        return view($this->view . '.edit', compact('organisationMember'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrganisationMember $request, OrganisationMember $organisationMember)
    {
        $organisationMember->update($request->all());
        return redirect()->route('organisations.show', $organisationMember->organisation_id)
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrganisationMember  $organisationMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganisationMember $organisationMember)
    {
        $organisationMember->delete();
        $previous = url()->previous();
        if (str_contains($previous, 'characters')) {
            return redirect()->route('characters.show', [$organisationMember->character_id, 'tab' => 'organisation'])
                ->with('success', trans($this->view . '.destroy.success'));
        }
        return redirect()->route('organisations.show', [$organisationMember->organisation_id, 'tab' => 'member'])
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
