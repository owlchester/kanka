<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWebhook;
use App\Models\Campaign;
use App\Models\Webhook;
use App\Jobs\TestWebhookJob;

class WebhookController extends Controller
{
    protected string $view = 'webhooks';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        Datagrid::layout(\App\Renderers\Layouts\Campaign\Webhook::class);

        $this->authorize('webhooks', $campaign);

        $webhooks = $campaign->webhooks()
            ->sort(request()->only(['o', 'k']))
            //->with(['users', 'permissions', 'campaign'])
            ->orderBy('updated_at', 'DESC')
            //->orderBy('name')
            ->paginate();

        $rows = $webhooks;

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

        return view('campaigns.webhooks', compact('campaign', 'rows', 'webhooks'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('webhooks', $campaign);

        return view('campaigns.webhooks.create', ['campaign' => $campaign]);
    }


    public function store(StoreWebhook $request, Campaign $campaign)
    {
        $this->authorize('webhooks', $campaign);
        if ($request->ajax()) {
            return response()->json();
        }

        $data = $request->all() + ['campaign_id' => $campaign->id];
        Webhook::create($data);

        return redirect()->route('webhooks.index', $campaign)
            ->with('success', __('campaigns/webhooks.create.success'));
    }

    public function edit(Campaign $campaign, Webhook $webhook)
    {
        $this->authorize('webhooks', $campaign);

        return view('campaigns.webhooks.edit', [
            'campaign' => $campaign,
            'webhook' => $webhook,
        ]);
    }

    public function update(StoreWebhook $request, Campaign $campaign, Webhook $webhook)
    {
        $this->authorize('webhooks', $campaign);

        $webhook->update($request->all());
        return redirect()->route('webhooks.index', $campaign)
            ->with('success', __('campaigns/webhooks.edit.success'));
    }

    public function destroy(Campaign $campaign, Webhook $webhook)
    {
        $this->authorize('webhooks', $campaign);

        $webhook->delete();

        return redirect()->route('webhooks.index', $campaign)
            ->with('success', __('campaigns/webhooks.destroy.success'));
    }

    public function status(Campaign $campaign, Webhook $webhook)
    {
        $this->authorize('webhooks', $campaign);

        return view('campaigns.webhooks.status', [
            'campaign' => $campaign,
            'webhook' => $webhook,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function toggle(Campaign $campaign, Webhook $webhook)
    {
        $this->authorize('webhooks', $campaign);

        $webhook->update(['status' => !$webhook->status]);

        return redirect()->route('webhooks.index', $campaign)
            ->with(
                'success',
                __('campaigns/webhooks.toggle.success')
            );
    }

    /**
     */
    public function bulk(Campaign $campaign)
    {
        $this->authorize('webhooks', $campaign);

        $action = request()->get('action');
        $models = request()->get('model');
        if (!in_array($action, ['enable', 'disable', 'delete']) || empty($models)) {
            return redirect()
                ->route('webhooks.index', $campaign);
        }
        $count = 0;
        foreach ($models as $id) {
            /** @var Webhook|null $webhook */
            $webhook = Webhook::find($id);
            if ($webhook === null) {
                continue;
            }

            if ($action === 'delete') {
                $webhook->delete();
                $count++;
            }

            if ($action === 'disable' && $webhook->status) {
                $webhook->update(['status' => 0]);
                $count++;
            }

            if ($action === 'enable' && !$webhook->status) {
                $webhook->update(['status' => 1]);
                $count++;
            }
        }

        return redirect()
            ->route('webhooks.index', $campaign)
            ->with('success', trans_choice('campaigns/webhooks.actions.bulks.' . $action . '_success', $count, ['count' => $count]));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function test(Campaign $campaign, Webhook $webhook)
    {
        $this->authorize('webhooks', $campaign);

        TestWebhookJob::dispatch($campaign, auth()->user(), $webhook, $webhook->action);

        return redirect()->route('webhooks.index', $campaign)
            ->with(
                'success',
                __('campaigns/webhooks.test.success')
            );
    }
}
