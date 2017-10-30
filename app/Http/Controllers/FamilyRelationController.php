<?php

namespace App\Http\Controllers;

use App\Family;
use App\FamilyRelation;
use App\Http\Requests\StoreFamily;
use App\Http\Requests\StoreFamilyRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FamilyRelationController extends Controller
{
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
        $models = FamilyRelation::paginate();
        return view('families.relations.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $family = Family::findOrFail(request()->get('family'));
        return view('families.relations.create', compact('family'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFamilyRelation $request)
    {
        $relation = FamilyRelation::create($request->all());
        return redirect()->route('families.show', [$relation->first_id, 'tab' => 'relation'])->with('success', 'Family relationship created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Family  $character
     * @return \Illuminate\Http\Response
     */
    public function show(FamilyRelation $familyRelation)
    {
        return view('families.relations.show', compact('characterRelation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Family  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(FamilyRelation $familyRelation)
    {
        return view('families.relations.edit', compact('characterRelation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Family  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFamilyRelation $request, FamilyRelation $familyRelation)
    {
        $familyRelation->update($request->all());
        return redirect()->route('families.show', $familyRelation->first_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FamilyRelation  $familyRelation
     * @return \Illuminate\Http\Response
     */
    public function destroy(FamilyRelation $familyRelation)
    {
        $familyRelation->delete();
        return redirect()->route('families.show', [$familyRelation->first_id, 'tab' => 'relation']);
    }
}
