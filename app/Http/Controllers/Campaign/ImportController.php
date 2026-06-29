<?php

namespace App\Http\Controllers\Campaign;

use App\Enums\CampaignImportStatus;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignImport;
use App\Services\Campaign\Import\PrepareService;
use App\Services\Campaign\Import\SignedUploadService;
use Illuminate\Http\JsonResponse;

class ImportController extends Controller
{
    protected PrepareService $service;

    public function __construct(PrepareService $prepareService, protected SignedUploadService $signedUploadService)
    {
        $this->middleware('auth');
        $this->service = $prepareService;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        Datagrid::layout(\App\Renderers\Layouts\Campaign\CampaignImport::class);

        $rows = $campaign->campaignImports()
            ->sort(request()->only(['o', 'k']))
            ->where('status_id', '<>', CampaignImportStatus::PREPARED)
            ->with(['user'])
            ->orderBy('updated_at', 'desc')
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            $html = view('layouts.datagrid._table')->with('rows', $rows)->render();

            return response()->json([
                'success' => true,
                'html' => $html,
            ]);
        }

        $token = null;
        if (auth()->user()->can('import', $campaign)) {
            $token = $this->service
                ->campaign($campaign)
                ->user(auth()->user())
                ->token();
        }

        return view('campaigns.import.index')
            ->with('campaign', $campaign)
            ->with('token', $token)
            ->with('rows', $rows);
    }

    public function presign(Campaign $campaign, CampaignImport $campaignImport): JsonResponse
    {
        $this->authorize('import', $campaign);

        if ($campaignImport->campaign_id !== $campaign->id) {
            abort(403);
        }

        if (! $campaignImport->isPrepared()) {
            abort(422);
        }

        $ext = request()->validate(['ext' => 'required|in:zip,csv'])['ext'];

        $result = $this->signedUploadService->campaign($campaign)->presign($campaignImport, $ext);

        return response()->json($result);
    }

    public function confirm(Campaign $campaign, CampaignImport $campaignImport): JsonResponse
    {
        $this->authorize('import', $campaign);

        if ($campaignImport->campaign_id !== $campaign->id) {
            abort(403);
        }

        if (! $campaignImport->isPrepared()) {
            abort(422);
        }

        $this->signedUploadService->campaign($campaign)->confirm($campaignImport);

        return response()->json(['success' => true]);
    }

    public function csv(Campaign $campaign, CampaignImport $campaignImport)
    {
        $this->authorize('setting', $campaign);

        return view('campaigns.import.process-csv')
            ->with('campaign', $campaign)
            ->with('import', $campaignImport);
    }
}
