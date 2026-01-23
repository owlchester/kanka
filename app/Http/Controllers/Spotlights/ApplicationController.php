<?php

namespace App\Http\Controllers\Spotlights;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Spotlights\ApplyRequest;
use App\Models\Campaign;
use App\Services\Spotlights\ApplyService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function __construct(protected ApplyService $service)
    {
        $this->middleware(['auth', 'identity']);
    }

    public function index()
    {
        $campaigns = auth()->user()->campaigns;
        return view('spotlights.index')
            ->with('campaigns', $campaigns);
    }

    public function form(Campaign $campaign)
    {
        $this->authorize('member', $campaign);

        $content = $this->service
            ->campaign($campaign)
            ->content();

        return view('spotlights.form')
            ->with('campaign', $campaign)
            ->with('content', $content);
    }

    public function save(ApplyRequest $request, Campaign $campaign)
    {
        $this->authorize('member', $campaign);

        $this->service
            ->campaign($campaign)
            ->user(auth()->user())
            ->request($request);

        if ($request->get('action') == 'apply') {
            try {
                $this->service->apply();

                return redirect()
                    ->route('spotlights.form', [$campaign])
                    ->with('success', __('spotlights.apply.success'));

            } catch (TranslatableException $e) {
                return redirect()
                    ->route('spotlights.form', [$campaign])
                    ->with('error', $e->getTranslatedMessage());
            }
        }

        $this->service->save();

        return redirect()
            ->route('spotlights.form', [$campaign])
            ->with('success', __('spotlights.form.success'));
    }


    public function retract(Request $request, Campaign $campaign)
    {
        $this->authorize('member', $campaign);

        $this->service
            ->campaign($campaign)
            ->user(auth()->user())
            ->retract();

        return redirect()
            ->route('spotlights.form', [$campaign])
            ->with('success', __('spotlights.retract.success'));


    }
}
