<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignDashboardWidget;
use App\Models\Campaign;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;
use App\Services\EntityService;

class DashboardWidgetController extends Controller
{
    /**
     * @var EntityService
     */
    protected $entityService;

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
        return redirect()->route('dashboard.setup', $campaign);
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
            'campaign' => $campaign,
            'widget' => $widget,
            'entities' => $entities,
            'dashboard' => $dashboard
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCampaignDashboardWidget $request, Campaign $campaign)
    {
        $this->authorize('dashboard', $campaign);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $widget = CampaignDashboardWidget::create($data);

        return redirect()
            ->route('dashboard.setup', $widget->dashboard_id ? [$campaign, 'dashboard' => $widget->dashboard_id] : $campaign)
            ->with('success', __('dashboard.widgets.create.success'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        return redirect()->route('dashboard', $campaign);
    }

    /**
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
            'widget' => $campaignDashboardWidget->widget->value,
            'entities' => $entities,
            'dashboards' => $dashboards,
        ]);
    }

    /**
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

        return redirect()
            ->route('dashboard.setup', $campaignDashboardWidget->dashboard_id ? [$campaign, 'dashboard' => $campaignDashboardWidget->dashboard_id] : $campaign)
            ->with('success', __('dashboard.widgets.update.success'));
    }

    public function destroy(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('dashboard', $campaign);
        $campaignDashboardWidget->delete();

        return redirect()
            ->route('dashboard.setup', $campaignDashboardWidget->dashboard_id ? [$campaign, 'dashboard' => $campaignDashboardWidget->dashboard_id] : $campaign)
            ->with('success', __('dashboard.widgets.delete.success'));
    }

    /**
     * Get a list of available entities
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
