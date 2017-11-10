<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNote;
use App\Note;
use Illuminate\Support\Facades\Session;

class NoteController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'notes';

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
        $models = Note::search(request()->get('search'))
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
    public function store(StoreNote $request)
    {
        Note::create($request->all());
        if ($request->has('submit-new')) {
            return redirect()->route($this->view . '.create')
                ->with('success', trans($this->view . '.create.success'));
        }
        return redirect()->route($this->view . '.index')
            ->with('success', trans($this->view . '.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        return view($this->view . '.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        return view($this->view . '.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function update(StoreNote $request, Note $note)
    {
        $note->update($request->all());
        if ($request->has('submit-new')) {
            return redirect()->route($this->view . '.create')
                ->with('success', trans($this->view . '.edit.success'));
        }
        return redirect()->route($this->view . '.show', $note->id)
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route($this->view . '.index')
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
