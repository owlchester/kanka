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

        $dashboard = request()->has('dashboard') ? CampaignDashboard::where('id', request()->get('dashboard'))->first() : null;

        return view('dashboard.widgets.forms.form', [
            'widget' => $widget,
            'entities' => $entities,
            'dashboard' => $dashboard
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCampaignDashboardWidget $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);

        $widget = CampaignDashboardWidget::create($request->all());

        return redirect()->route('dashboard.setup', $widget->dashboard_id ? ['dashboard' => $widget->dashboard_id] : null)
            ->with('success', trans('dashboard.widgets.create.success'));
    }

    public function show(CampaignDashboardWidget $campaignDashboardWidget)
    {
        return redirect()->route('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaignDashboardWidget $campaignDashboardWidget)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('dashboard', $campaign);
        $entities = $this->buildEntities();

        return view('dashboard.widgets.forms.form', [
            'model' => $campaignDashboardWidget,
            'widget' => $campaignDashboardWidget->widget,
            'entities' => $entities
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

        return redirect()->route('dashboard.setup', $campaignDashboardWidget->dashboard_id ? ['dashboard' => $campaignDashboardWidget->dashboard_id] : null)
            ->with('success', trans('dashboard.widgets.update.success'));
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

        return redirect()->route('dashboard.setup', $campaignDashboardWidget->dashboard_id ? ['dashboard' => $campaignDashboardWidget->dashboard_id] : null)
            ->with('success', trans('dashboard.widgets.delete.success'));
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

        foreach ($this->entityService->getEnabledEntities(CampaignLocalization::getCampaign(), ['menu_links']) as $entity) {
            $entities[$entity] = __('entities.' . $entity);
        }

        return $entities;
    }
}
