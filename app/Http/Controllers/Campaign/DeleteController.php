<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteCampaign;
use App\Models\Campaign;
use App\Services\Campaign\DeletionService;

class DeleteController extends Controller
{
    protected DeletionService $deletionService;

    public function __construct(DeletionService $deletionService)
    {
        $this->middleware('auth');
        $this->deletionService = $deletionService;
    }

    public function show(Campaign $campaign)
    {
        $this->authorize('roles', $campaign);

        return view('campaigns.delete')
            ->with('campaign', $campaign);
    }

    public function destroy(DeleteCampaign $request, Campaign $campaign)
    {
        $this->authorize('delete', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $this->deletionService
            ->campaign($campaign)
            ->user($request->user())
            ->delete();

        return redirect()->route('home')
            ->with('success', __('campaigns/delete.success', ['name' => $campaign->name]));
    }
}
