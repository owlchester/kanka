<?php

namespace App\Http\Controllers\Maps\Reorders;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderGroups;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapGroup;

class GroupController extends Controller
{
    public function index(ReorderGroups $request, Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map->entity);

        $order = 1;
        $ids = $request->get('group');
        foreach ($ids as $id) {
            $group = MapGroup::where('id', $id)->where('map_id', $map->id)->first();
            if (empty($group)) {
                continue;
            }
            $group->position = $order;
            $group->updateQuietly();
            $order++;
        }
        $order--;

        return redirect()
            ->route('maps.map_groups.index', [$campaign, 'map' => $map])
            ->with('success', trans_choice('maps/groups.reorder.success', $order, ['count' => $order]));
    }
}
