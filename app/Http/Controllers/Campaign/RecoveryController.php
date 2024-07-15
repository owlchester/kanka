<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\RecoveryService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    protected RecoveryService $service;

    public function __construct(RecoveryService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        Datagrid::layout(\App\Renderers\Layouts\Campaign\Recovery::class)
            ->permissions(false);

        $rows = Entity::onlyTrashed()
            ->with('image')
            ->sort(request()->only(['o', 'k']), ['deleted_at' => 'DESC'])
            ->whereDate('deleted_at', '>=', Carbon::today()->subDays(config('entities.hard_delete')))
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            $html = view('layouts.datagrid._table')
                ->with('rows', $rows)
                ->render();
            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        return view('campaigns.recovery.index', compact('rows', 'campaign'));
    }

    public function recover(Request $request, Campaign $campaign)
    {
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        if (!$campaign->boosted()) {
            return redirect()
                ->route('recovery', $campaign)
                ->with('boosted-pitch', true)
            ;
        }

        try {
            $count = $this->service->recover($request->get('model', []));
            return redirect()
                ->route('recovery', $campaign)
                ->with('success', trans_choice('campaigns/recovery.success', $count, ['count' => $count]));
        } catch (Exception $e) {
            return redirect()
                ->route('recovery', $campaign)
                ->with('error', __('campaigns/recovery.error'));
        }
    }
}
