<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCampaign;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartController extends Controller
{
    public function __construct()
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

        $first = ! Auth::user()->hasCampaigns();
        $options = $request->all();
        $options['entry'] = '';
        $options['excerpt'] = '';
        $campaign = Campaign::create($options);

        if ($first) {
            return redirect()->route('dashboard', $campaign);
        }

        return redirect()->route('dashboard', $campaign)
            ->with('success', __('campaigns.create.success'));
    }
}
