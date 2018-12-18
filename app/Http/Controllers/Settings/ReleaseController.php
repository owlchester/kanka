<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Release;

class ReleaseController extends Controller
{
    /**
     * Update the user's last viewed release
     * @param Release $release
     */
    public function read(Release $release)
    {
        if (auth()->check()) {
            auth()->user()->release = $release->id;
            auth()->user()->save();
        }
        return response()->json([
            'success' => false
        ]);
    }
}