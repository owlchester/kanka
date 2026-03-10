<?php

namespace App\Http\Controllers\Campaign;

use App\Enums\CampaignImportStatus;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignImport;
use App\Services\Campaign\Import\PrepareService;

class ImportController extends Controller
{
    protected PrepareService $service;

    public function __construct(PrepareService $prepareService)
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
            ->orderBy('updated_at', 'DESC')
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

    public function csv(Campaign $campaign, CampaignImport $campaignImport)
    {
        $this->authorize('setting', $campaign);

        return view('campaigns.import.process-csv')
            ->with('campaign', $campaign)
            ->with('import', $campaignImport);
    }
}
