<?php

namespace App\Http\Controllers\Maps\Layers;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapLayer;
use App\Services\Maps\MigrateLayerService;
use App\Traits\CampaignAware;

class MigrateController extends Controller
{
    use CampaignAware;

    protected MigrateLayerService $service;

    public function __construct(MigrateLayerService $migrateLayerService)
    {
        $this->service = $migrateLayerService;
    }

    public function index(Campaign $campaign, Map $map, MapLayer $mapLayer)
    {
        $this->authorize('update', $map->entity);

        // For ajax requests, send back that the validation succeeded, so we can really send the form to be saved.
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        try {
            $this->service->layer($mapLayer)->migrate();
        } catch (TranslatableException $e) {
            return redirect()
                ->route('maps.map_layers.edit', [$campaign, $map, $mapLayer])
                ->with('error', $e->getTranslatedMessage());
        } catch (\Exception $e) {

        }

        return redirect()
            ->route('maps.map_layers.edit', [$campaign, $map, $mapLayer])
            ->withSuccess('Map layer image migrated.');
    }
}
