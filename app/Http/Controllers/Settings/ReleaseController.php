<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReadBanner;
use App\Models\AppRelease;
use Illuminate\Support\Collection;
use Stevebauman\Purify\Facades\Purify;

class ReleaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'identity']);
    }

    /**
     * Update the user's last viewed release
     * @param AppRelease $appRelease
     */
    public function read(AppRelease $appRelease)
    {
        $user = auth()->user();
        /** @var Collection $settings */
        $settings = $user->settings;
        $settings->put('releases_' . $appRelease->category_id, $appRelease->id);
        $user->settings = $settings;
        $user->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function banner(ReadBanner $request)
    {
        $user = $request->user();
        $settings = $user->settings;
        $code = $request->get('code');

        $code = Purify::clean($code);
        $settings->put('banner_' . $code, true);
        $user->settings = $settings;
        $user->save();

        return response()->json([
            'success' => true
        ]);

    }

}
