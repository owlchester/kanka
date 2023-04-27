<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Http\Requests\StoreCharacterFamily;

class CharacterFamilyController extends Controller
{
    /**
     * @var string
     */
    protected string $view = 'families.members';

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
    public function create(Family $family)
    {
        $this->authorize('update', $family);
        $ajax = request()->ajax();

        return view($this->view . '.create', [
            'model' => $family,
            'ajax' => $ajax
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCharacterFamily $request, Family $family)
    {
        $this->authorize('update', $family);

        $newMembers = $family->members()->syncWithoutDetaching($request->members);

        return redirect()->route('families.show', $family->id)
            ->with('success', trans_choice($this->view . '.create.success', count($newMembers['attached']), ['count' => count($newMembers['attached'])]));
    }
}
