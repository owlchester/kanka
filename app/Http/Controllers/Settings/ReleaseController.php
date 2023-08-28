<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReadBanner;
use App\Models\AppRelease;
use App\Services\TutorialService;
use Illuminate\Support\Collection;
use Stevebauman\Purify\Facades\Purify;

class ReleaseController extends Controller
{
    protected TutorialService $tutorialService;

    public function __construct(TutorialService $tutorialService)
    {
        $this->middleware(['auth', 'identity']);
        $this->tutorialService = $tutorialService;
    }

    /**
     * Update the user's last viewed release
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
            // Old code
        } else {
            $settings->put($section . $code, true);
            $user->settings = $settings;
            $user->save();
        }

        return response()->json([
            'success' => true
        ]);
    }
}
