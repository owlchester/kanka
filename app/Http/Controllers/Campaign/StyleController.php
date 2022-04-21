<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderStyles;
use App\Http\Requests\StoreCampaignStyle;
use App\Http\Requests\StoreCampaignTheme;
use App\Models\Campaign;
use App\Models\CampaignStyle;
use App\Services\Campaign\UserService;

class StyleController extends Controller
{
    /** @var UserService */
    protected $service;

    const MAX_THEMES = 30;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->middleware('campaign.boosted', ['except' => 'index']);
        $this->service = $userService;
    }

    public function index()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('recover', $campaign);
        $styles = $campaign->styles()->sort(request()->only(['o', 'k']))->take(self::MAX_THEMES)->get();
        $theme = $campaign->theme;
        $reorderStyles = $campaign->styles()->defaultOrder()->take(self::MAX_THEMES)->get();

        return view('campaigns.styles.index', compact('campaign', 'styles', 'theme', 'reorderStyles'));
    }

    public function show(CampaignStyle $campaignStyle)
    {
        return redirect()
            ->route('campaign_styles.index');
    }

    public function create()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        if ($campaign->styles()->count() >= self::MAX_THEMES) {
            return redirect()->route('campaign_styles.index')
                ->with('error', __('campaigns/styles.errors.max_reached', ['max' => self::MAX_THEMES]));
        }
        return view('campaigns.styles.create', compact('campaign'));
    }

    public function store(StoreCampaignStyle $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        if ($campaign->styles()->count() >= self::MAX_THEMES) {
            return redirect()->route('campaign_styles.index')
                ->with('error', __('campaigns/styles.errors.max_reached', ['max' => self::MAX_THEMES]));
        }

        $style = new CampaignStyle($request->only('name', 'content', 'is_enabled'));
        $style->campaign_id = $campaign->id;
        $style->save();
        CampaignCache::clearStyles();

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', __('campaigns/styles.create.success'));
    }

    public function edit(CampaignStyle $campaignStyle)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $style = $campaignStyle;
        return view('campaigns.styles.edit', compact('campaign', 'style'));
    }

    public function update(StoreCampaignStyle $request, CampaignStyle $campaignStyle)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $campaignStyle->update($request->only('name', 'content', 'is_enabled'));
        CampaignCache::clearStyles();

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', __('campaigns/styles.update.success', ['name' => $campaignStyle->name]));

    }

    public function destroy(CampaignStyle $campaignStyle)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $campaignStyle->delete();
        CampaignCache::clearStyles();

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', __('campaigns/styles.delete.success', ['name' => $campaignStyle->name]));

    }

    public function theme()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $themes = [null => __('campaigns.themes.none')];
        foreach (\App\Models\Theme::all() as $theme) {
            $themes[$theme->id] = $theme->__toString();
        }

        return view('campaigns.styles.theme', compact('campaign', 'themes'));
    }

    public function themeSave(StoreCampaignTheme $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $campaign->update([
            'theme_id' => $request->get('theme_id')
        ]);

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', __('campaigns/styles.theme.success'))
        ;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function bulk()
    {
        $action = request()->get('action');
        $models = request()->get('model');
        if (!in_array($action, ['enable', 'disable', 'delete']) || empty($models)) {
            return redirect()
                ->route('campaign_styles.index');
        }

        $count = 0;
        foreach ($models as $id) {
            /** @var CampaignStyle $style */
            $style = CampaignStyle::find($id);
            if (empty($style)) {
                continue;
            }
            if ($action === 'enable' && !$style->is_enabled) {
                $style->is_enabled = true;
                $style->update();
                $count++;
            } elseif ($action === 'disable' && $style->is_enabled) {
                $style->is_enabled = false;
                $style->update();
                $count++;
            } elseif ($action === 'delete') {
                $style->delete();
                $count++;
            }
        }
        CampaignCache::clearStyles();

        return redirect()
            ->route('campaign_styles.index')
            ->with('success', trans_choice('campaigns/styles.bulks.' . $action, $count, ['count' => $count]))
        ;
    }

    public function reorder(ReorderStyles $request)
    {
        $order = 1;
        $ids = $request->get('style');
        foreach ($ids as $id) {
            $style = CampaignStyle::find($id);
            if (empty($style)) {
                continue;
            }
            $style->order = $order;
            $style->timestamps = false;
            $style->update();
            $order++;
        }
        CampaignCache::clearStyles();

        $order--;
        return redirect()
            ->route('campaign_styles.index')
            ->with('success', trans_choice('campaigns/styles.reorder.success', $order, ['count' => $order]))
            ;


    }
}
