<?php

namespace App\Http\Controllers;

use App\Character;
use App\Http\Requests\StoreCharacter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CharacterController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'characters';

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
        $models = Character::with('location')
            ->search(request()->get('search'))
            ->order(request()->get('order'))
            ->paginate();
        return view('characters.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Character::class);

        return view('characters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCharacter $request)
    {
        $this->authorize('create', Character::class);

        Character::create($request->all());
        if ($request->has('submit-new')) {
            return redirect()->route($this->view . '.create')
                ->with('success', trans($this->view . '.create.success'));
        }
        return redirect()->route('characters.index')->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Character $character)
    {
        $this->authorize('view', $character);
        return view('characters.show', compact('character'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character)
    {
        $this->authorize('update', $character);

        return view('characters.edit', compact('character'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCharacter $request, Character $character)
    {
        $this->authorize('update', $character);

        $character->update($request->all());
        if ($request->has('submit-new')) {
            return redirect()->route($this->view . '.create')
                ->with('success', trans($this->view . '.edit.success'));
        }
        return redirect()->route('characters.show', $character->id)->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Character $character)
    {
        $this->authorize('delete', $character);

        $character->delete();
        return redirect()->route($this->view . '.index')->with('success', trans($this->view . '.destroy.success'));
    }
}
