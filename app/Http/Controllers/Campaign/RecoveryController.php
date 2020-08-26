<?php


namespace App\Http\Controllers\Campaign;


use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Services\RecoveryService;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    /** @var RecoveryService */
    protected $service;

    public function __construct(RecoveryService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted');

        $this->service = $service;
    }

    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);

        $entities = Entity::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->paginate();

        return view('campaigns.recovery.index', compact('entities', 'campaign'));
    }

    public function recover(Request $request)
    {
        try {
            $count = $this->service->recover($request->only('ids'));
            return redirect()
                ->route('recovery')
                ->with('success', trans_choice('campaigns/recovery.success', $count, ['count' => $count]));
        } catch (\Exception $e) {

            return redirect()
                ->route('recovery')
                ->with('error', __('campaigns/recovery.error'));
        }
    }
}
