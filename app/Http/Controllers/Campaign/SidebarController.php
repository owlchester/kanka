<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Campaigns\Boosted;
use App\Http\Requests\Campaigns\SaveSidebarLayoutRequest;
use App\Models\Campaign;
use App\Services\Campaign\Sidebar\LayoutService;
use App\Services\Campaign\Sidebar\SaveService;
use App\Services\Campaign\Sidebar\SetupService;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
    public function __construct(protected SetupService $service, protected SaveService $saveService, protected LayoutService $layouts)
    {
        $this->middleware('auth');
        $this->middleware(Boosted::class, ['only' => ['save']]);
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $this->layouts->campaign($campaign);
        $revision = $this->layouts->revision();
        if ($this->layouts->enabled()) {
            $this->authorize('admin', $campaign);
            $target = request()->query('role', 'default');
            abort_unless(is_string($target) && ($target === 'default' || (ctype_digit($target) && $campaign->roles()->whereKey($target)->exists())), 404);

            return view('campaigns.sidebar.v2', [
                'campaign' => $campaign,
                'revision' => $revision,
                'target' => $target,
                'roles' => $campaign->roles()->get(),
                'layout' => $this->layouts->layout($target),
                'standard' => $this->layouts->standard(),
                'default' => $this->layouts->layout(),
                'catalog' => array_values($this->layouts->catalog()),
            ]);
        }

        $layout = $this->service->campaign($campaign)->withDisabled()->layout();

        return view(
            'campaigns.sidebar.index',
            compact(
                'campaign',
                'layout',
                'revision',
            )
        );
    }

    public function saveLayout(SaveSidebarLayoutRequest $request, Campaign $campaign)
    {
        if ($request->ajax() && ! $request->isJson()) {
            return response()->json();
        }

        $data = $request->validated();
        $this->layouts->campaign($campaign)->save($data, $request->user());

        return redirect()->route('campaign-sidebar', [
            $campaign, 'role' => $data['target'],
        ])->with('success', __('campaigns/sidebar.success'));
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
