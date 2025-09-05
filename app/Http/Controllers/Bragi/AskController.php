<?php

namespace App\Http\Controllers\Bragi;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\ApiKeys\SaveService;

class AskController extends Controller
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

        return view('campaigns.ask-bragi', compact('campaign'));
    }
}
