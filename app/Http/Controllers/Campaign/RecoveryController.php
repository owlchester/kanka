<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Entity\RecoveryService as EntityRecoveryService;
use App\Services\Posts\RecoveryService;
use App\Services\Entity\RecoverySetupService;
use Exception;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    public function __construct(
        protected RecoveryService $postService,
        protected EntityRecoveryService $entityService,
        protected RecoverySetupService $recoverySetupService
    ) {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        return view('campaigns.recovery.index', compact('campaign'));
    }

    public function setup(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        return response()->json(
            $this->recoverySetupService
                ->user(auth()->user())
                ->campaign($campaign)
                ->setup()
        );
    }

    public function recover(Request $request, Campaign $campaign)
    {
        if (!$campaign->boosted()) {
            return redirect()
                ->route('recovery', $campaign)
                ->with('boosted-pitch', true)
            ;
        }

        $this->authorize('recover', $campaign);

        try {
            $entities = $this->entityService->recover($request->get('entities', []));
            $posts = $this->postService->recover($request->get('posts', []));

            $count = count($entities) + count($posts);

            return response()->json(['entities' => $entities, 'posts' => $posts, 'toast' => trans_choice('campaigns/recovery.success_v2', $count, ['count' => $count])]);
        } catch (Exception $e) {
            return redirect()
                ->route('recovery', $campaign)
                ->with('error', __('campaigns/recovery.error'));
        }
    }
}
