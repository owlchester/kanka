<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    protected ExportService $service;

    public function __construct(ExportService $exportService)
    {
        $this->middleware('auth');
        $this->service = $exportService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('setting', $campaign);
        return view('campaigns.export', compact('campaign'));
    }

    /**
     * Dispatch the campaign export jobs and have the user wait a bit
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function export(Request $request, Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        if (!$campaign->exportable()) {
            return response()->json(['error' => __('campaigns/export.errors.limit')]);
        }

        $this->service
            ->campaign($campaign)
            ->user($request->user())
            ->export();

        return response()->json(['success' => __('campaigns/export.success')]);
    }
}
