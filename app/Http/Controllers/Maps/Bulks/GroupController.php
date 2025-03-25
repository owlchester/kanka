<?php

namespace App\Http\Controllers\Maps\Bulks;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Datagrid2\BulkControllerTrait;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapGroup;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;

    public function index(Request $request, Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map->entity);

        $action = $request->get('action');
        $models = $request->get('model');
        if (! in_array($action, $this->validBulkActions()) || empty($models)) {
            return redirect()->back();
        }

        if ($action === 'edit') {
            return $this->bulkBatch(route('maps.groups.bulk', [$campaign, 'map' => $map]), '_map-group', $models);
        }

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        $count = $this->bulkProcess($request, MapGroup::class);

        return redirect()
            ->route('maps.map_groups.index', [$campaign, 'map' => $map])
            ->with('success', trans_choice('maps/groups.bulks.' . $action, $count, ['count' => $count]));
    }
}
