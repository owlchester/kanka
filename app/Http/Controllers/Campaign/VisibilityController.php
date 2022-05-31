<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\CampaignCache;
use App\Facades\CampaignLocalization;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreCampaignVisibility;
use App\Http\Requests\ReorderStyles;
use App\Http\Requests\StoreCampaignStyle;
use App\Http\Requests\StoreCampaignTheme;
use App\Models\Campaign;
use App\Models\CampaignStyle;
use App\Services\Campaign\UserService;

class VisibilityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->service = $userService;
    }

    public function edit()
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        return view('campaigns.forms.modals.public', compact('campaign'));
    }

    public function save(StoreCampaignVisibility $request)
    {
        $campaign = CampaignLocalization::getCampaign();
        $this->authorize('update', $campaign);

        $campaign->update([
            'is_public' => $request->get('is_public')
        ]);

        return redirect()
            ->back()
            ->with('success_raw', __('campaigns/public.update.' . ($campaign->isPublic() ? 'public' : 'private'), [
                'public-campaigns' => link_to_route('front.public_campaigns', __('front.menu.campaigns'), null, ['target' => '_blank']),
            ]))
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
