<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreCampaignDashboardWidget;
use App\Models\CampaignDashboardWidget;

class CampaignDashboardWidgetController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
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

        return view('dashboard.widgets.form', [
            'widget' => $widget
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

        CampaignDashboardWidget::create($request->all());

        return redirect()->route('dashboard.setup')
            ->with('success', trans('dashboard.widgets.create.success'));
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

        return view('dashboard.widgets.form', [
            'model' => $campaignDashboardWidget,
            'widget' => $campaignDashboardWidget->widget,
        ]);
    }
}