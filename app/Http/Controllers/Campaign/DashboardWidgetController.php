<?php

namespace App\Http\Controllers\Campaign;

use App\Enums\Widget;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignDashboardWidget;
use App\Models\Campaign;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardWidget;
use App\Models\Entity;
use App\Services\EntityTypeService;

class DashboardWidgetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected EntityTypeService $entityTypeService)
    {
        $this->middleware('auth');
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

        if ($widget === 'gallery' && ! $campaign->premium()) {
            return view('components.premium-dialog', [
                'title' => __('dashboards/widgets/gallery.name'),
                'campaign' => $campaign,
                'doc' => 'guides/dashboard.html#gallery',
                'pitch' => __('dashboards/widgets/gallery.helpers.premium'),
            ]);
        }

        $entityTypes = $this->entityTypeService
            ->campaign($campaign)
            ->exclude([config('entities.ids.bookmark')])
            ->prepend(['' => __('dashboard.widgets.random.type.all')])
            ->toSelect();

        $dashboard = request()->has('dashboard') ?
            CampaignDashboard::where('id', request()->get('dashboard'))->first() : null;
        $dashboards = $campaign->premium() ? CampaignDashboard::where('campaign_id', $campaign->id)->orderBy('name')->pluck('name', 'id')->toArray() : [];

        $widgetClass = new CampaignDashboardWidget;
        $widgetClass->widget = $widget;

        return view('dashboard.widgets.forms.create', [
            'campaign' => $campaign,
            'widget' => $widget,
            'widgetClass' => $widgetClass,
            'entityTypes' => $entityTypes,
            'dashboard' => $dashboard,
            'dashboards' => $dashboards,
            'premium' => $campaign->premium(),
        ]);
    }

    public function store(StoreCampaignDashboardWidget $request, Campaign $campaign)
    {
        $this->authorize('dashboard', $campaign);
        if ($request->input('widget') === Widget::Gallery->value) {
            $this->authorize('galleryWidget', $campaign);
        }
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $data = $this->prepareWidgetTarget($data);
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

        $dashboards = $campaign->premium() ? CampaignDashboard::where('campaign_id', $campaign->id)->orderBy('name')->pluck('name', 'id')->toArray() : [];

        $entityTypes = $this->entityTypeService
            ->campaign($campaign)
            ->exclude([config('entities.ids.bookmark')])
            ->prepend(['' => __('dashboard.widgets.random.type.all')])
            ->toSelect();

        return view('dashboard.widgets.forms.edit', [
            'campaign' => $campaign,
            'model' => $campaignDashboardWidget,
            'widget' => $campaignDashboardWidget->widget->value,
            'entityTypes' => $entityTypes,
            'dashboards' => $dashboards,
            'premium' => $campaign->premium(),
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
        $input = $this->prepareWidgetTarget($input);

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

    protected function prepareWidgetTarget(array $data): array
    {
        if (($data['widget'] ?? null) !== Widget::Header->value) {
            return $data;
        }

        $targetType = $data['target_type'] ?? null;
        if ($targetType === 'dashboard') {
            $data['target_type'] = CampaignDashboard::class;
            $data['target_id'] = $data['target_dashboard_id'] ?? null;
        } elseif ($targetType === 'entity') {
            $data['target_type'] = Entity::class;
            $data['target_id'] = $data['entity_id'] ?? null;
        } else {
            $data['target_type'] = null;
            $data['target_id'] = null;
        }
        unset($data['target_dashboard_id']);
        $data['entity_id'] = null;

        return $data;
    }
}
