<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaign;
use App\Models\Campaign;
use App\Services\Campaign\CreateService;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function __construct(protected CreateService $createService)
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('create', new Campaign);

        // A user with campaigns doesn't need this process.
        $tracking = null;
        if (session()->has('user_registered')) {
            session()->remove('user_registered');
            $tracking = 'pa10CJTvrssBEOaOq7oC';
        }

        return view('campaigns.forms.create', [
            'start' => auth()->user()->campaigns->count() === 0,
            'gaTrackingEvent' => $tracking,
        ]);
    }

    public function store(StoreCampaign $request)
    {
        $this->authorize('create', new Campaign);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $first = auth()->user()->campaigns->count() === 0;
        $campaign = $this->createService
            ->request($request)
            ->user($request->user())
            ->create();

        if ($request->has('submit-update')) {
            return redirect()
                ->route('campaigns.edit', $campaign)
                ->with('success', __('campaigns.create.success', ['name' => $campaign->name]));
        } elseif ($request->has('submit-new')) {
            return redirect()
                ->route('start')
                ->with('success', __('campaigns.create.success', ['name' => $campaign->name]));
        } elseif ($first) {
            return redirect()->route('dashboard', $campaign);
        }

        return redirect()->route('dashboard', $campaign)
            ->with('success', __('campaigns.create.success', ['name' => $campaign->name]));
    }
}
