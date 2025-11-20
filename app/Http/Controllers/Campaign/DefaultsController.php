<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreDefaults;
use App\Models\Campaign;

class DefaultsController extends Controller
{
    public function index(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return view('campaigns.defaults.index', compact('campaign'));
    }

    public function save(StoreDefaults $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $campaign->update($request->all());

        return redirect()->route('campaign-defaults', $campaign)
            ->with('success', __('campaigns/defaults.update.success'));
    }
}
