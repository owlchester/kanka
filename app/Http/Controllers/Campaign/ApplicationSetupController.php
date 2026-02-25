<?php

namespace App\Http\Controllers\Campaign;

use App\Enums\CampaignFilterType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Campaigns\StoreCampaignSetup;
use App\Models\Campaign;
use App\Models\CampaignFilter;
use App\Services\Campaign\ApplicationService;
use App\Services\LanguageService;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class ApplicationSetupController extends Controller
{
    public function __construct(protected ApplicationService $service, protected LanguageService $languageService)
    {
        $this->middleware('auth');
    }

    public function setup(Campaign $campaign)
    {
        $this->authorize('applications', $campaign);

        $timezones = [];

        for ($i = -12; $i <= 14; $i++) {
            $prefix = ($i >= 0) ? '+' : '-';
            // Formats to "UTC +05:00" or "UTC -11:00"
            $utcString = 'UTC ' . $prefix . Str::padLeft((string) abs($i), 2, '0') . ':00';

            $timezones[$utcString] = $utcString;
        }

        $user = auth()->user();
        $isElemental = $user->isElemental();
        $prioritisedCampaign = null;

        if ($isElemental) {
            $adminCampaignIds = $user->campaignRoles()->where('is_admin', true)->pluck('campaign_id');
            $prioritisedCampaign = Campaign::where('is_prioritised', true)
                ->where('id', '!=', $campaign->id)
                ->whereIn('id', $adminCampaignIds)
                ->first();
        }

        $languages = $this->languageService->getSupportedLanguagesList(true);

        return view('campaigns.applications.setup')
            ->with('campaign', $campaign)
            ->with('timezones', $timezones)
            ->with('languages', $languages)
            ->with('isElemental', $isElemental)
            ->with('prioritisedCampaign', $prioritisedCampaign);
    }

    public function saveSetup(StoreCampaignSetup $request, Campaign $campaign)
    {
        $this->authorize('applications', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $isPrioritised = false;
        $user = auth()->user();

        if ($user->isElemental() && $request->boolean('is_prioritised')) {
            $adminCampaignIds = $user->campaignRoles()->where('is_admin', true)->pluck('campaign_id');
            $conflicting = Campaign::where('is_prioritised', true)
                ->where('id', '!=', $campaign->id)
                ->whereIn('id', $adminCampaignIds)
                ->first();

            if ($conflicting) {
                return redirect()->back()
                    ->with('error', __('campaigns/applications.setup.prioritise_conflict', [
                        'campaign' => '<a href="' . route('campaign-applications.setup', $conflicting) . '" class="text-link">' . e($conflicting->name) . '</a>',
                    ]));
            }

            $isPrioritised = true;
        }

        $campaign->update([
            'locale' => $request->get('locale'),
            'is_prioritised' => $isPrioritised,
        ]);

        $campaign->systems()->sync($request->input('systems', []));
        $campaign->genres()->sync($request->input('genres', []));
        $campaign->playstyles()->sync($request->input('playstyles', []));

        // Map request keys to Enum types
        $filters = [
            'intro' => CampaignFilterType::Intro,
            'timezone' => CampaignFilterType::Timezone,
            'schedule' => CampaignFilterType::Schedule,
            'players' => CampaignFilterType::PlayerCount,
        ];

        foreach ($filters as $inputKey => $enumType) {
            // Only save if the user actually sent data for this field
            if ($request->filled($inputKey)) {
                CampaignFilter::updateOrCreate(
                    [
                        'campaign_id' => $campaign->id,
                        'type' => $enumType,
                    ],
                    [
                        'entry' => Purify::clean($request->input($inputKey)),
                    ]
                );
            }
        }

        $campaign->refresh();
        $successKey = $user->can('canOpen', $campaign)
            ? 'campaigns/applications.setup.success_complete'
            : 'campaigns/applications.setup.success';

        return redirect()
            ->route('applications.index', $campaign)
            ->with('success', __($successKey));
    }
}
