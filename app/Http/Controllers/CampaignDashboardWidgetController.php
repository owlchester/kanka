<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreCampaignDashboardWidget;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;
use App\Services\EntityService;

class CampaignDashboardWidgetController extends Controller
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
    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        return redirect()->route('dashboard.setup');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        $widget = request()->get('widget', 'preview');
        $entities = $this->buildEntities();

        $dashboard = request()->has('dashboard') ?
            CampaignDashboard::where('id', request()->get('dashboard'))->first() : null;

        return view('dashboard.widgets.forms.create', [
            'widget' => $widget,
            'entities' => $entities,
            'dashboard' => $dashboard
        ]);
    }

    /**
     * @param StoreCampaignDashboardWidget $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCampaignDashboardWidget $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        $widget = CampaignDashboardWidget::create($request->all());

        return redirect()
            ->route('dashboard.setup', $widget->dashboard_id ? ['dashboard' => $widget->dashboard_id] : null)
            ->with('success', __('dashboard.widgets.create.success'));
    }

    /**
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(CampaignDashboardWidget $campaignDashboardWidget)
    {
        return redirect()->route('dashboard');
    }

    /**
     * @param CampaignDashboardWidget $campaignDashboardWidget
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(CampaignDashboardWidget $campaignDashboardWidget)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);
        $entities = $this->buildEntities();

        $dashboards = [null => __('dashboard.dashboards.default.title')];
        foreach (CampaignDashboard::orderBy('name')->pluck('name', 'id')->toArray() as $id => $dashboard) {
            $dashboards[$id] = $dashboard;
        }

        return view('dashboard.widgets.forms.edit', [
            'model' => $campaignDashboardWidget,
            'widget' => $campaignDashboardWidget->widget,
            'entities' => $entities,
            'dashboards' => $dashboards
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCampaignDashboardWidget $request, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        $campaignDashboardWidget->update($request->all());

        return redirect()
            ->route('dashboard.setup', $campaignDashboardWidget->dashboard_id ? ['dashboard' => $campaignDashboardWidget->dashboard_id] : null)
            ->with('success', __('dashboard.widgets.update.success'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(\Illuminate\Http\Request $request, CampaignDashboardWidget $campaignDashboardWidget)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        $campaignDashboardWidget->delete();

        return redirect()
            ->route('dashboard.setup', $campaignDashboardWidget->dashboard_id ? ['dashboard' => $campaignDashboardWidget->dashboard_id] : null)
            ->with('success', __('dashboard.widgets.delete.success'));
    }

    /**
     * Get a list of available entities
     * @return array
     */
    private function buildEntities()
    {
        $entities = [
            '' => 'All',
        ];

        $enabledEntities = $this
            ->entityService
            ->getEnabledEntities(CampaignLocalization::getCampaign(), ['menu_links']);
        foreach ($enabledEntities as $entity) {
            $entities[$entity] = __('entities.' . $entity);
        }

        return $entities;
    }
}
