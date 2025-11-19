<?php

namespace App\Http\Controllers\Campaign;

use App\Enums\Widget;
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

        $this->entityService = $entityService;
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('dashboard', $campaign);

        $dashboard = null;
        if (request()->get('dashboard')) {
            $dashboard = CampaignDashboard::findOrFail(request()->get('dashboard'));
        }

        $withOnboarding = $campaign->widgets()->onDashboard($dashboard)->where('widget', Widget::Onboarding)->count() === 0;
        $withHelp = $campaign->widgets()->onDashboard($dashboard)->where('widget', Widget::Help)->count() === 0;

        return view('dashboard.widgets.selection')
            ->with('campaign', $campaign)
            ->with('dashboard', $dashboard)
            ->with('withOnboarding', $withOnboarding)
            ->with('withHelp', $withHelp);
    }

    public function create(Campaign $campaign)
    {
        $this->authorize('dashboard', $campaign);

        $widget = request()->get('widget', 'preview');
        if (! view()->exists('dashboard.widgets.forms._' . $widget)) {
            abort(404);
        }
        $entities = $this->buildEntities($campaign);

        $dashboard = request()->has('dashboard') ?
            CampaignDashboard::where('id', request()->get('dashboard'))->first() : null;

        return view('dashboard.widgets.forms.create', [
            'campaign' => $campaign,
            'widget' => $widget,
            'entities' => $entities,
            'dashboard' => $dashboard,
        ]);
    }

    public function store(StoreCampaignDashboardWidget $request, Campaign $campaign)
    {
        $this->authorize('dashboard', $campaign);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $widget = CampaignDashboardWidget::create($data);

        return redirect()
            ->route('dashboard.setup', $widget->dashboard_id ?
                [$campaign, 'dashboard' => $widget->dashboard_id] : $campaign)
            ->with('success', __('dashboard.widgets.create.success'));
    }

    public function show(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        return redirect()->route('dashboard', $campaign);
    }

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

    public function update(StoreCampaignDashboardWidget $request, Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('dashboard', $campaign);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        // get all request data
        $input = $request->all();
        // force entity_id to take null if not present in data
        $input['entity_id'] = $request->input('entity_id');

        $campaignDashboardWidget->update($input);

        return redirect()
            ->route('dashboard.setup', $campaignDashboardWidget->dashboard_id ?
                [$campaign, 'dashboard' => $campaignDashboardWidget->dashboard_id] : $campaign)
            ->with('success', __('dashboard.widgets.update.success'));
    }

    public function destroy(Campaign $campaign, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $this->authorize('dashboard', $campaign);
        $campaignDashboardWidget->delete();

        return redirect()
            ->route('dashboard.setup', $campaignDashboardWidget->dashboard_id ?
                [$campaign, 'dashboard' => $campaignDashboardWidget->dashboard_id] : $campaign)
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
            ->getEnabledEntities($campaign, ['bookmarks']);
        foreach ($enabledEntities as $entity) {
            $entities[$entity] = __('entities.' . $entity);
        }

        return $entities;
    }
}
