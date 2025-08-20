<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignApiKey;
use App\Models\Campaign;
use App\Models\CampaignApiKey;
use App\Services\Campaign\ApiKeys\SaveService;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
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
            //->orderBy('updated_at', 'DESC')
            ->paginate();

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

        $this->service->campaign($campaign)->user($request->user())->request($request)->create();

        return redirect()->route('api-keys.index', $campaign)
            ->with('success', __('campaigns/api-keys.create.success'));
    }

    public function edit(Campaign $campaign, CampaignApiKey $apiKey)
    {
        $this->authorize('apiKeys', $campaign);

        return view('campaigns.api-keys.edit', [
            'campaign' => $campaign,
            'apiKey' => $apiKey,
        ]);
    }

    public function update(Request $request, Campaign $campaign, CampaignApiKey $apiKey)
    {
        $this->authorize('apiKeys', $campaign);

        $apiKey->update($request->all());

        return redirect()->route('api-keys.index', $campaign)
            ->with('success', __('campaigns/api-keys.edit.success'));
    }

    public function destroy(Campaign $campaign, CampaignApiKey $apiKey)
    {
        $this->authorize('apiKeys', $campaign);

        $apiKey->delete();

        return redirect()->route('api-keys.index', $campaign)
            ->with('success', __('campaigns/api-keys.destroy.success'));
    }
}
