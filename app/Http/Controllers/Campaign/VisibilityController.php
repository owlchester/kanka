<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreCampaignVisibility;
use App\Models\Campaign;

class VisibilityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        $from = request()->get('from');

        return view('campaigns.forms.modals.public', compact('campaign', 'from'));
    }

    public function save(StoreCampaignVisibility $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $campaign->update([
            'is_public' => $request->get('is_public'),
        ]);

        $success = __('campaigns/public.update.' . ($campaign->isPublic() ? 'public' : 'private'), [
            'public-campaigns' => '<a href="https://kanka.io/campaigns" target="_blank">' . __('footer.public-campaigns') . '</a>',
        ]);

        if ($request->get('from') === 'overview') {
            return redirect()
                ->route('overview', $campaign)
                ->with('success_raw', $success);
        }

        return redirect()
            ->back()
            ->with('success_raw', $success);
    }
}
