<?php


namespace App\Http\Controllers\Campaign;


use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Services\RecoveryService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RecoveryController extends Controller
{
    /** @var RecoveryService */
    protected $service;

    public function __construct(RecoveryService $service)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted', ['except' => 'index']);

        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);

        $entities = Entity::onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->whereDate('deleted_at', '>=', Carbon::today()->subDays(config('entities.hard_delete')))
            ->paginate();

        return view('campaigns.recovery.index', compact('entities', 'campaign'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
