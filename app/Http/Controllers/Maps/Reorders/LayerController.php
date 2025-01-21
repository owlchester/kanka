<?php

namespace App\Http\Controllers\Maps\Reorders;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderLayers;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapLayer;

class LayerController extends Controller
{
    /**
     * Controls drag and drop reordering of map layers
     */
    public function index(ReorderLayers $request, Campaign $campaign, Map $map)
    {
        $this->authorize('update', $map->entity);

        $order = 1;
        $ids = $request->get('layer');
        foreach ($ids as $id) {
            $layer = MapLayer::where('id', $id)->where('map_id', $map->id)->first();
            if (empty($layer)) {
                continue;
            }
            $layer->position = $order;
            $layer->updateQuietly();
            $order++;
        }
        $order--;

        return redirect()
            ->route('maps.map_layers.index', [$campaign, $map])
            ->with('success', trans_choice('maps/layers.reorder.success', $order, ['count' => $order]));
    }
}
