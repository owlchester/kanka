<?php

namespace App\Http\Controllers\Campaign;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Plugin;
use App\Services\Campaign\PluginService;
use Exception;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    public function __construct(protected PluginService $service) {}

    public function index(Campaign $campaign)
    {
        Datagrid::layout(\App\Renderers\Layouts\Campaign\Plugin::class);

        $highlight = request()->get('highlight');
        if (! empty($highlight)) {
            Datagrid::highlight(function () use ($highlight) {
                // @phpstan-ignore-next-line
                return $this->uuid === $highlight;
            });
        }

        $plugins = $campaign->plugins()
            ->preparedSelect()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->highlighted($highlight)
            ->has('user')
            ->with('versions');

        if (auth()->guest() || ! auth()->user()->can('member', $campaign)) {
            $plugins->where('campaign_plugins.is_active', true);
        }
        $rows = $plugins->paginate();

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

        return view('campaigns.plugins', compact('campaign', 'rows', 'highlight'));
    }

    public function delete(Request $request, Campaign $campaign, Plugin $plugin)
    {
        $this->authorize('recover', $campaign);

        try {
            $this->service->campaign($campaign)->user($request->user())->plugin($plugin)->remove();

            return redirect()->route('campaign_plugins.index', $campaign)
                ->with(
                    'success',
                    __('campaigns/plugins.destroy.success', ['plugin' => $plugin->name])
                );
        } catch (Exception $e) {
            return redirect()->route('campaign_plugins.index', $campaign)
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }
}
