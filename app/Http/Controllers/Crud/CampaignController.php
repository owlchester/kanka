<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCampaign;
use App\Models\Campaign;
use App\Services\MultiEditingService;

class CampaignController extends Controller
{
    protected string $view = 'campaigns';

    public function __construct()
    {
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
            /** @var MultiEditingService $editingService */
            $editingService = app()->make(MultiEditingService::class);
            $editingUsers = $editingService->model($campaign)->user(auth()->user())->users();
            // If no one is editing the model, we are now editing it
            if (empty($editingUsers)) {
                $editingService->edit();
            }
        }

        return view($this->view . '.forms.edit', [
            'campaign' => $campaign,
            'model' => $campaign,
            'start' => false,
            'editingUsers' => $editingUsers,
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

        /** @var MultiEditingService $editingService */
        $editingService = app()->make(MultiEditingService::class);
        $editingService->model($campaign)
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
