<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Release;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    /**
     * Update the user's welcome read attribute
     * @param Release $release
     */
    public function read()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->welcome_campaign_id = null;
            $user->save();
        }
        return response()->json([
            'success' => true
        ]);
    }
}
