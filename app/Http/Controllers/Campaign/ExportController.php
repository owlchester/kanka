<?php

namespace App\Http\Controllers\Campaign;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\ExportService;
use App\Services\CampaignService;
use App\Services\EntityService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * @var ExportService
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ExportService $exportService)
    {
        $this->middleware('auth');
        $this->service = $exportService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        return view('campaigns.export', compact('campaign'));
    }

    /**
     * Dispatch the campaign export jobs and have the user wait a bit
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function export(Request $request)
    {
        $campaign = CampaignLocalization::getCampaign();
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
