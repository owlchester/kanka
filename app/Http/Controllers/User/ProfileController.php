<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     */
    public function show(User $user)
    {
        $campaigns = $user->campaigns()->public()->front()->paginate();

        return view('users.profile')
            ->with('user', $user)
            ->with('campaigns', $campaigns)
        ;
    }
}
