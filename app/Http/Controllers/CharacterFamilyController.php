<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
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

}
