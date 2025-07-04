<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bulks\Copy;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use App\Services\Users\CampaignService;
use Illuminate\Http\Request;

class CopyController extends Controller
{
    public function __construct(
        protected BulkService $bulkService,
        protected CampaignService $campaignService
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $entities = $request->get('entities');
        $campaigns = $this->campaignService
            ->user(auth()->user())
            ->campaign($campaign)
            ->campaigns();

        return view('cruds.datagrids.bulks.modals._copy_campaign')
            ->with('campaign', $campaign)
            ->with('campaigns', $campaigns)
            ->with('entityType', $entityType)
            ->with('type', $entityType->code)
            ->with('entities', $entities);
    }

    public function apply(Copy $request, Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', $request->get('models'));
        if ($request->has('entities')) {
            $models = $request->get('entities');
        }

        /** @var Campaign $target */
        $target = Campaign::findOrFail($request->get('campaign'));

        $count = $this
            ->bulkService
            ->entityType($entityType)
            ->campaign($campaign)
            ->user($request->user())
            ->entities($models)
            ->copyToCampaign($target);

        $link = '<a href="' . route('dashboard', $target) . '">' . $target->name . '</a>';

        return redirect()
            ->back()
            ->with('success_raw', trans_choice('crud.bulk.success.copy_to_campaign', $count, ['count' => $count, 'campaign' => $link]));
    }
}
