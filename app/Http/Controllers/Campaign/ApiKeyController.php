<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignApiKey;
use App\Models\Campaign;
use App\Models\CampaignApiKey;
use App\Services\Campaign\ApiKeys\SaveService;

class ApiKeyController extends Controller
{
    protected string $view = 'webhooks';

    public function __construct(protected SaveService $service)
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        Datagrid::layout(\App\Renderers\Layouts\Campaign\CampaignApiKey::class);

        $this->authorize('apiKeys', $campaign);
        $rows = $campaign->apiKeys()
            ->sort(request()->only(['o', 'k']))
            //->with(['user', 'campaign'])
            ->orderBy('updated_at', 'DESC')
            ->paginate();

            //dd($rows);
        // Ajax Datagrid
        if (request()->ajax()) {
            $html = view('layouts.datagrid._table')->with('rows', $rows)->with('campaign', $campaign)->render();
            $deletes = view('layouts.datagrid.delete-forms')->with('models', Datagrid::deleteForms())->with('campaign', $campaign)->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'deletes' => $deletes,
            ]);
        }

        return view('campaigns.api-keys', compact('campaign', 'rows'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('apiKeys', $campaign);

        return view('campaigns.api-keys.create', ['campaign' => $campaign]);
    }

    public function store(StoreCampaignApiKey $request, Campaign $campaign)
    {
        $this->authorize('apiKeys', $campaign);

        if ($request->ajax()) {
            return response()->json();
        }

        $new = $this->service->campaign($campaign)->user($request->user())->request($request)->save();

        return redirect()->route('api-keys.index', $campaign)
            ->with('success', __('campaigns/api-keys.create.success'));
    }

    public function edit(Campaign $campaign, CampaignApiKey $campaignApiKey)
    {
        $this->authorize('api-keys', $campaign);

        return view('campaigns.api-keys.edit', [
            'campaign' => $campaign,
            'api-key' => $campaignApiKey,
        ]);
    }

    public function update(StoreCampaignApiKey $request, Campaign $campaign, CampaignApiKey $campaignApiKey)
    {
        $this->authorize('apiKeys', $campaign);

        $this->service
            ->campaign($campaign)
            ->user($request->user())
            ->apiKey($campaignApiKey)
            ->request($request)
            ->save();
        $campaignApiKey->update($request->all());

        return redirect()->route('api-keys.index', $campaign)
            ->with('success', __('campaigns/api-keys.edit.success'));
    }

    public function destroy(Campaign $campaign, CampaignApiKey $campaignApiKey)
    {
        $this->authorize('apiKeys', $campaign);

        $campaignApiKey->delete();

        return redirect()->route('api-keys.index', $campaign)
            ->with('success', __('campaigns/api-keys.destroy.success'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function toggle(Campaign $campaign, CampaignApiKey $campaignApiKey)
    {
        $this->authorize('apiKeys', $campaign);

        if ($campaignApiKey->status != 1) {
            $message = __('campaigns/api-keys.toggle.enable');
        } else {
            $message = __('campaigns/api-keys.toggle.disable');
        }

        $campaignApiKey->update(['status' => ! $campaignApiKey->status]);

        return redirect()->route('api-keys.index', $campaign)
            ->with(
                'success',
                $message
            );
    }
}
