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
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(AppRelease $appRelease)
    {
        $user = auth()->user();
        /** @var Collection $settings */
        $settings = $user->settings();
        $settings->put('releases_' . $appRelease->category_id, $appRelease->id);
        $user->settings = $settings;
        $user->save();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param ReadBanner $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function banner(ReadBanner $request)
    {
        $user = auth()->user();
        $settings = $user->settings();
        $code = $request->get('code');

        $code = Purify::clean($code);

        // Figure out if this is a banner, or tutorial we are hiding from the user
        $section = 'banner_';
        if ($request->get('type') === 'tutorial') {
            $section = 'tutorial_';
        }
        $settings->put($section . $code, true);
        $user->settings = $settings;
        $user->save();

        return response()->json([
            'success' => true
        ]);
    }
}
