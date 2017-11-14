<?php

namespace App\Http\Controllers;

use App\Journal;
use App\Http\Requests\StoreJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JournalController extends Controller
{
    /**
     * @var string
     */
    protected $view = 'journals';

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
        $models = Journal::search(request()->get('search'))
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
        $this->authorize('create', Journal::class);

        return view($this->view . '.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJournal $request)
    {
        $this->authorize('create', Journal::class);

        Journal::create($request->all());
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
     * @param  \App\Journal  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        $this->authorize('view', $journal);

        return view($this->view . '.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journal  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        $this->authorize('update', $journal);

        return view($this->view . '.edit', compact('journal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $character
     * @return \Illuminate\Http\Response
     */
    public function update(StoreJournal $request, Journal $journal)
    {
        $this->authorize('update', $journal);

        $journal->update($request->all());
        if ($request->has('submit-new')) {
            return redirect()->route($this->view . '.create')
                ->with('success', trans($this->view . '.edit.success'));
        }
        return redirect()->route($this->view . '.show', $journal->id)
            ->with('success', trans($this->view . '.edit.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Journal  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        $this->authorize('delete', $journal);

        $journal->delete();
        return redirect()->route($this->view . '.index')
            ->with('success', trans($this->view . '.destroy.success'));
    }
}
