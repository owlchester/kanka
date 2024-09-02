<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Entity\RecoveryService as EntityRecoveryService;
use App\Services\Posts\RecoveryService;
use App\Services\Entity\RecoverySetupService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecoveryController extends Controller
{
    protected RecoveryService $postService;
    protected EntityRecoveryService $entityService;
    protected RecoverySetupService $service;


    public function __construct(RecoveryService $postService, EntityRecoveryService $entityService, RecoverySetupService $recoverySetupService)
    {
        $this->middleware('auth');
        $this->postService = $postService;
        $this->entityService = $entityService;
        $this->service = $recoverySetupService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        $elements = DB::select(
            'select id, name, deleted_at, deleted_by, "entity" as type
                from entities
                where deleted_at is not null and campaign_id = ' . $campaign->id . '
                union all
                select p.id, p.name, p.deleted_at, p.deleted_by, "post" as type
                from posts as p
                left join entities as e on e.id = p.entity_id
                where p.deleted_at is not null and e.deleted_at is null and e.campaign_id = ' . $campaign->id .
                ' order by deleted_at DESC'
        );

        return view('campaigns.recovery.index', compact('elements', 'campaign'));
    }


    public function setup(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        return response()->json(
            $this->service
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

        try {
            $entities = $this->entityService->recover($request->get('entities', []));
            $posts = $this->postService->recover($request->get('posts', []));

            $count = count($entities) + count($posts);

            return response()->json(['entities' => $entities, 'posts' => $posts, 'toast' => trans_choice('campaigns/recovery.success_v2', $count, ['count' => $count])]);

            return redirect()
                ->route('recovery', $campaign)
                ->with('success', trans_choice('campaigns/recovery.success_v2', $count, ['count' => $count]));
        } catch (Exception $e) {
            return redirect()
                ->route('recovery', $campaign)
                ->with('error', __('campaigns/recovery.error'));
        }
    }
}
