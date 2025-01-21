<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bulks\Copy;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;

class CopyController extends Controller
{
    public function __construct(
        protected BulkService $bulkService,
    ) {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {
        return view('cruds.datagrids.bulks.modals._copy_campaign')
            ->with('campaign', $campaign)
            ->with('entityType', $entityType)
            ->with('type', $entityType->code)
        ;
    }

    public function apply(Copy $request, Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', $request->get('models'));

        /** @var Campaign $target */
        $target = Campaign::findOrFail($request->get('campaign'));

        $count = $this
            ->bulkService
            ->entityType($entityType)
            ->campaign($campaign)
            ->entities($models)
            ->copyToCampaign($target);

        $link = '<a href="' . route('dashboard', $target) . '">' . $target->name . '</a>';
        return redirect()
            ->back()
            ->with('success_raw', trans_choice('crud.bulk.success.copy_to_campaign', $count, ['count' => $count, 'campaign' => $link]));
    }
}
