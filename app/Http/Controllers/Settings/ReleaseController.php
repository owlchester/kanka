<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\AppRelease;
use App\Models\Release;
use Illuminate\Support\Collection;

class ReleaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity', 'shadow']);
    }

    /**
     * Update the user's last viewed release
     * @param AppRelease $appRelease
     */
    public function read(AppRelease $appRelease)
    {
        if (auth()->check() && !\App\Facades\Identity::isImpersonating()) {
            $user = auth()->user();
            /** @var Collection $settings */
            $settings = $user->settings;
            $settings->put('releases_' . $appRelease->category_id, $appRelease->id);
            $user->settings = $settings;
            $user->save();
        }
        return response()->json([
            'success' => true
        ]);
    }
}
