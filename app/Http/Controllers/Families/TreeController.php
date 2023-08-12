<?php

namespace App\Http\Controllers\Families;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Family;
use App\Traits\GuestAuthTrait;

class TreeController extends Controller
{
    use GuestAuthTrait;

    public function index(Campaign $campaign, Family $family)
    {
        $this->authView($family);

        return view('families.trees.index')
            ->with('family', $family)
            ->with('campaign', $campaign)
            ->with('mode', 'vue')
        ;
    }
}
