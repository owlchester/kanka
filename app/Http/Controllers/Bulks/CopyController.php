<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;

class CopyController extends Controller
{
    protected BulkService $bulkService;

    public function __construct(
        BulkService $bulkService,
    ) {
        $this->bulkService = $bulkService;

        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {
        return view('cruds.datagrids.bulks.modals._copy_campaign')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('type', $entityType->code)
        ;
    }

    public function apply(Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', request()->get('models'));
        $campaignId = request()->get('campaign');

        $count = $this
            ->bulkService
            ->entity($entityType->code)
            ->campaign($campaign)
            ->entities($models)
            ->copyToCampaign($campaignId);

        $target = Campaign::findOrFail($campaignId);
        return redirect()
            ->back()
            ->with('success_raw', trans_choice('crud.bulk.success.copy_to_campaign', $count, ['count' => $count, 'campaign' => $target->name]));
    }
}
