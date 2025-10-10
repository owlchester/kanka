<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Campaigns\Boosted;
use App\Models\Campaign;
use App\Services\Campaign\Sidebar\SaveService;
use App\Services\Campaign\Sidebar\SetupService;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
    public function __construct(protected SetupService $service, protected SaveService $saveService)
    {
        $this->middleware('auth');
        $this->middleware(Boosted::class, ['except' => 'index']);
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $layout = $this->service->campaign($campaign)->withDisabled()->layout();

        return view(
            'campaigns.sidebar.index',
            compact(
                'campaign',
                'layout',
            )
        );
    }

    public function save(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $this->saveService
            ->campaign($campaign)
            ->user(auth()->user())
            ->save(request()->all());

        return redirect()
            ->route('campaign-sidebar', $campaign)
            ->with('success', __('campaigns/sidebar.success'));
    }

    public function reset(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $this->saveService
            ->campaign($campaign)
            ->user(auth()->user())
            ->reset();

        return redirect()
            ->route('campaign-sidebar', $campaign)
            ->with('success', __('campaigns/sidebar.reset.success'));
    }
}
