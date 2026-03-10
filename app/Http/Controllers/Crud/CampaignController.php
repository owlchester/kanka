<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCampaign;
use App\Models\Campaign;
use App\Services\Campaign\GenreService;
use App\Services\Campaign\SystemService;
use App\Services\LanguageService;
use App\Services\MultiEditingService;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    protected string $view = 'campaigns';

    public function __construct(
        protected MultiEditingService $editingService,
        protected GenreService $genreService,
        protected SystemService $systemService,
        protected LanguageService $languageService
    ) {
        $this->middleware('auth', ['except' => ['index', 'show', 'css']]);
    }

    public function show(Campaign $campaign)
    {
        return view($this->view . '.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $editingUsers = null;

        if ($campaign->hasEditingWarning()) {
            $editingUsers = $this->editingService
                ->model($campaign)
                ->user(auth()->user())
                ->users();
            // If no one is editing the model, we are now editing it
            if (empty($editingUsers)) {
                $this->editingService->edit();
            }
        }
        $languages = $this->languageService->getSupportedLanguagesList(true);
        $timezones = [];

        for ($i = -12; $i <= 14; $i++) {
            $prefix = ($i >= 0) ? '+' : '-';
            // Formats to "UTC +05:00" or "UTC -11:00"
            $utcString = 'UTC ' . $prefix . Str::padLeft((string) abs($i), 2, '0') . ':00';

            $timezones[$utcString] = $utcString;
        }

        return view($this->view . '.forms.edit', [
            'campaign' => $campaign,
            'model' => $campaign,
            'start' => false,
            'editingUsers' => $editingUsers,
            'languages' => $languages,
            'timezones' => $timezones,
        ]);
    }

    public function update(UpdateCampaign $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->all();
        // Missing sidebar config? Because we shouldn't have used the same array...
        if (! empty($campaign->ui_settings['sidebar'])) {
            $data['ui_settings']['sidebar'] = $campaign->ui_settings['sidebar'];
        }
        // Also, let's unset ui_settings that are set to true
        foreach ($data['ui_settings'] as $key => $value) {
            if ($value === '0') {
                unset($data['ui_settings'][$key]);
            }
        }
        // Same mumbo jumbo for module settings...
        if (! empty($campaign->settings['modules'])) {
            $data['settings']['modules'] = $campaign->settings['modules'];
        }

        if ($request->filled('vanity') && $campaign->premium()) {
            $data['slug'] = $request->post('vanity');
        }

        $campaign->update($data);
        $this->genreService->campaign($campaign)->save($request->post('genres', []));
        $this->systemService->campaign($campaign)->save($request->post('systems', []));

        $this->editingService
            ->model($campaign)
            ->user($request->user())
            ->finish();

        if ($request->has('submit-update')) {
            return redirect()
                ->route('campaigns.edit', $campaign)
                ->with('success', __($this->view . '.edit.success', ['name' => $campaign->name]));
        }
        if ($request->has('submit-new')) {
            return redirect()
                ->route('start')
                ->with('success', __($this->view . '.edit.success', ['name' => $campaign->name]));
        }

        return redirect()->route('overview', $campaign)
            ->with('success', __($this->view . '.edit.success', ['name' => $campaign->name]));
    }
}
