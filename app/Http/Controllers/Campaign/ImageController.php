<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreImage;
use App\Models\Campaign;

class ImageController extends Controller
{
    public function index(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return view('campaigns.forms.modals.image')
            ->with('campaign', $campaign);
    }

    public function save(StoreImage $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $campaign->update($request->only('image', 'image_url'));

        return redirect()->route('dashboard', $campaign)->with('success', __('campaigns/sidebar.image-success'));
    }
}
