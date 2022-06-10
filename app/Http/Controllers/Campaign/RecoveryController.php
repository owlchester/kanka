<?php


namespace App\Http\Controllers\Campaign;


use App\Facades\CampaignLocalization;
use App\Facades\Datagrid;
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

        Datagrid::layout(\App\Renderers\Layouts\Campaign\Recovery::class)
            ->permissions(false);

        $rows = Entity::onlyTrashed()
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recover(Request $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        if (!$campaign->boosted()) {
            return redirect()
                ->route('recovery')
                ->with('boosted-pitch', true)
            ;
        }
        try {
            $count = $this->service->recover($request->get('model', []));
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
