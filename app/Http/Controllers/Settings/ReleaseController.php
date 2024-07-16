<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\AppRelease;
use App\Services\TutorialService;

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

        //Track it using the system already set up for tutorials.
        $this->tutorialService->user($user)->track('releases_' . $appRelease->category_id . '_' . $appRelease->id);

        return response()->json([
            'success' => true
        ]);
    }
}
