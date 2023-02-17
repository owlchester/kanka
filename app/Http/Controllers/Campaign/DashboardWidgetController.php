<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignDashboardWidget;
use App\Models\Campaign;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;
use App\Services\EntityService;

class DashboardWidgetController extends Controller
{
    protected EntityService $entityService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntityService $entityService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');

        $this->entityService = $entityService;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('dashboard', $campaign);

        return redirect()->route('dashboard.setup', [$campaign]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('dashboard', $campaign);

        $widget = request()->get('widget', 'preview');
        if (!view()->exists('dashboard.widgets.forms._' . $widget)) {
            abort(404);
        }
        $entities = $this->buildEntities($campaign);

        $dashboard = request()->has('dashboard') ?
            CampaignDashboard::where('id', request()->get('dashboard'))->first() : null;

        return view('dashboard.widgets.forms.create', [
            'widget' => $widget,
            'campaign' => $campaign,
            'entities' => $entities,
            'dashboard' => $dashboard
        ]);
    }

    /**
     * @param StoreCampaignDashboardWidget $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCampaignDashboardWidget $request, Campaign $campaign)
    {
        $this->authorize('dashboard', $campaign);

        $data = array_merge(['campaign_id' => $campaign->id], $request->all());
        $widget = CampaignDashboardWidget::create($data);

        $redirects = ['campaign' => $campaign];
        if ($widget->dashboard_id) {
            $redirects['dashboard'] = $widget->dashboard_id;
        }

        return redirect()
            ->route('dashboard.setup', $redirects)
            ->with('success', __('dashboard.widgets.create.success'));
    }

    /**
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        return redirect()->route('dashboard', [$campaign]);
    }

    /**
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('dashboard', $campaign);
        $entities = $this->buildEntities($campaign);

        $dashboards = [null => __('dashboard.dashboards.default.title')];
        foreach (CampaignDashboard::orderBy('name')->pluck('name', 'id')->toArray() as $id => $dashboard) {
            $dashboards[$id] = $dashboard;
        }

        return view('dashboard.widgets.forms.edit', [
            'campaign' => $campaign,
            'model' => $campaignDashboardWidget,
            'widget' => $campaignDashboardWidget->widget,
            'entities' => $entities,
            'dashboards' => $dashboards,
        ]);
    }

    /**
     * @param StoreCampaignDashboardWidget $request
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreCampaignDashboardWidget $request, Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('dashboard', $campaign);

        //get all request data
        $input = $request->all();
        //force entity_id to take null if not present in data
        $input['entity_id'] = $request->input('entity_id');

        $campaignDashboardWidget->update($input);

        $redirects = ['campaign' => $campaign];
        if ($campaignDashboardWidget->dashboard_id) {
            $redirects['dashboard'] = $campaignDashboardWidget->dashboard_id;
        }
        return redirect()
            ->route('dashboard.setup', $redirects)
            ->with('success', __('dashboard.widgets.update.success'));
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('dashboard', $campaign);

        $campaignDashboardWidget->delete();

        $redirects = ['campaign' => $campaign];
        if ($campaignDashboardWidget->dashboard_id) {
            $redirects['dashboard'] = $campaignDashboardWidget->dashboard_id;
        }
        return redirect()
            ->route('dashboard.setup', $redirects)
            ->with('success', __('dashboard.widgets.delete.success'));
    }

    /**
     * Get a list of available entities
     * @return array
     */
    private function buildEntities(Campaign $campaign): array
    {
        $entities = [
            '' => 'All',
        ];

        $enabledEntities = $this
            ->entityService
            ->getEnabledEntities($campaign, ['menu_links']);
        foreach ($enabledEntities as $entity) {
            $entities[$entity] = __('entities.' . $entity);
        }

        return $entities;
    }
}
