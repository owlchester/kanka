<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteCampaign;
use App\Http\Requests\StoreCampaign;
use App\Http\Requests\UpdateCampaign;
use App\Models\Campaign;
use App\Services\Campaign\DeletionService;
use App\Services\MultiEditingService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    protected string $view = 'campaigns';

    protected DeletionService $deletionService;

    /**
     * Create a new controller instance.
     *
     * CampaignController constructor.
     */
    public function __construct(DeletionService $deletionService)
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'css']]);
        $this->deletionService = $deletionService;
    }

    public function show(Campaign $campaign)
    {
        return view($this->view . '.show', compact('campaign'));
    }

    public function create(Campaign $campaign)
    {
        $this->authorize('create', $campaign);

        return view($this->view . '.forms.create', ['start' => false]);
    }

    public function store(StoreCampaign $request)
    {
        $campaign = new Campaign();
        $this->authorize('create', $campaign);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        $first = !auth()->user()->hasCampaigns();
        $data = $request->all();

        $data['entry'] = Arr::get($data, 'entry');
        $data['excerpt'] = Arr::get($data, 'excerpt');

        DB::beginTransaction();
        try {
            /** @var Campaign $campaign */
            $campaign = Campaign::create($data);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if ($request->has('submit-update')) {
            return redirect()
                ->to(app()->getLocale() . '/campaign/' . $campaign->id . '/campaigns/' . $campaign->id . '/edit')
                ->with('success', __($this->view . '.create.success'));
        } elseif ($request->has('submit-new')) {
            return redirect()
                ->route('start')
                ->with('success', __($this->view . '.create.success'));
        } elseif ($first) {
            $user = auth()->user();
            $user->save();
            return redirect()->route('dashboard', $campaign);
        }

        return redirect()->route('dashboard', $campaign)
            ->with('success', __($this->view . '.create.success'));
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
            'editingUsers' => $editingUsers
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
        if (!empty($campaign->ui_settings['sidebar'])) {
            $data['ui_settings']['sidebar'] = $campaign->ui_settings['sidebar'];
        }
        // Also, let's unset ui_settings that are set to true
        foreach ($data['ui_settings'] as $key => $value) {
            if ($value === '0') {
                unset($data['ui_settings'][$key]);
            }
        }
        // Same mumbo jumbo for module settings...
        if (!empty($campaign->settings['modules'])) {
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
                ->with('success', __($this->view . '.edit.success'));
        }
        if ($request->has('submit-new')) {
            return redirect()
                ->route('start')
                ->with('success', __($this->view . '.edit.success'));
        }

        return redirect()->route('overview', $campaign)
            ->with('success', __($this->view . '.edit.success'));
    }

    public function destroy(DeleteCampaign $request, Campaign $campaign)
    {
        $this->authorize('delete', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $this->deletionService
            ->campaign($campaign)
            ->user(auth()->user())
            ->delete();

        return redirect()->route('home');
    }
}
