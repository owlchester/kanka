<?php

namespace App\Http\Controllers;

use App\Models\Race;
use App\Http\Requests\StoreCharacterRace;

class CharacterRaceController extends Controller
{
    /**
     * @var string
     */
    protected string $view = 'races.members';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Race $race)
    {
        $this->authorize('update', $race);
        $ajax = request()->ajax();

        return view($this->view . '.create', [
            'model' => $race,
            'ajax' => $ajax
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCharacterRace $request, Race $race)
    {
        $this->authorize('update', $race);

        $newMembers = $race->characters()->syncWithoutDetaching($request->members);

        return redirect()->route('races.show', $race->id)
            ->with('success', trans_choice($this->view . '.create.success', count($newMembers['attached']), ['count' => count($newMembers['attached'])]));
    }
}
