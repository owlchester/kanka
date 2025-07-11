<?php

namespace App\Http\Controllers\Campaign;

use App\Events\Campaigns\Webhooks\WebhookTested;
use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWebhook;
use App\Jobs\TestWebhookJob;
use App\Models\Campaign;
use App\Models\Webhook;
use App\Services\Campaign\Webhooks\SaveService;

class WebhookController extends Controller
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
        Datagrid::layout(\App\Renderers\Layouts\Campaign\Webhook::class);

        $this->authorize('webhooks', $campaign);

        $rows = $campaign->webhooks()
            ->sort(request()->only(['o', 'k']))
            // ->with(['users', 'permissions', 'campaign'])
            ->orderBy('updated_at', 'DESC')
            // ->orderBy('name')
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

        return view('campaigns.webhooks', compact('campaign', 'rows'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign)
    {
        $this->authorize('webhooks', $campaign);

        if (! $campaign->premium()) {
            return view('campaigns.webhooks.not-premium')
                ->with('campaign', $campaign);
        }

        return view('campaigns.webhooks.create', ['campaign' => $campaign]);
    }

    public function store(StoreWebhook $request, Campaign $campaign)
    {
        $this->authorize('webhooks', $campaign);

        if (! $campaign->premium()) {
            return redirect()->route('webhooks.index', $campaign)
                ->with(
                    'error',
                    __('campaigns/webhooks.error.pitch')
                );
        }

        if ($request->ajax()) {
            return response()->json();
        }

        $new = $this->service->campaign($campaign)->user($request->user())->request($request)->save();

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

        $this->service
            ->campaign($campaign)
            ->user($request->user())
            ->webhook($webhook)
            ->request($request)
            ->save();
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

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function toggle(Campaign $campaign, Webhook $webhook)
    {
        $this->authorize('webhooks', $campaign);

        if ($webhook->status != 1) {
            $message = __('campaigns/webhooks.toggle.enable');
        } else {
            $message = __('campaigns/webhooks.toggle.disable');
        }

        $webhook->update(['status' => ! $webhook->status]);

        return redirect()->route('webhooks.index', $campaign)
            ->with(
                'success',
                $message
            );
    }

    public function bulk(Campaign $campaign)
    {
        $this->authorize('webhooks', $campaign);

        $action = request()->get('action');
        $models = request()->get('model');
        if (! in_array($action, ['enable', 'disable', 'delete']) || empty($models)) {
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
            } elseif ($action === 'disable' && $webhook->status) {
                $webhook->update(['status' => 0]);
                $count++;
            } elseif ($action === 'enable' && ! $webhook->status) {
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
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function test(Campaign $campaign, Webhook $webhook)
    {
        $this->authorize('webhooks', $campaign);

        if (! $campaign->premium()) {
            return redirect()->route('webhooks.index', $campaign)
                ->with(
                    'error',
                    __('campaigns/webhooks.error.pitch')
                );
        }

        TestWebhookJob::dispatch($campaign, auth()->user(), $webhook);

        WebhookTested::dispatch($webhook, auth()->user());

        return redirect()->route('webhooks.index', $campaign)
            ->with(
                'success',
                __('campaigns/webhooks.test.success')
            );
    }
}
