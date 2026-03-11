<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaign;
use App\Models\Campaign;
use App\Services\Campaign\CreateService;
use App\Services\Campaign\GenreService;
use App\Services\Campaign\SystemService;
use App\Services\LanguageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreateController extends Controller
{
    public function __construct(
        protected CreateService $createService,
        protected GenreService $genreService,
        protected SystemService $systemService,
        protected LanguageService $languageService
    ) {
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
        $languages = $this->languageService->getSupportedLanguagesList(true);
        $timezones = [];

        for ($i = -12; $i <= 14; $i++) {
            $prefix = ($i >= 0) ? '+' : '-';
            // Formats to "UTC +05:00" or "UTC -11:00"
            $utcString = 'UTC ' . $prefix . Str::padLeft((string) abs($i), 2, '0') . ':00';

            $timezones[$utcString] = $utcString;
        }

        return view('campaigns.forms.create', [
            'start' => auth()->user()->campaigns->count() === 0,
            'gaTrackingEvent' => $tracking,
            'languages' => $languages,
            'timezones' => $timezones
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

        $this->genreService->campaign($campaign)->save($request->post('genres', []));
        $this->systemService->campaign($campaign)->save($request->post('systems', []));

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
