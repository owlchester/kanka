<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Facades\EntityPermission;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMapSettings;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class SettingsController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function update(UpdateMapSettings $request, Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if (! $entity->isMap()) {
            abort(404);
        }
        // See the comment in Entity\Maps\MarkerController::preview() - authorize() needs the
        // permission service explicitly scoped to this campaign, otherwise it falls back to
        // EntityPermission::loadAllPermissions()'s "no campaign set" admin bypass.
        EntityPermission::campaign($campaign);
        $this->authorize('update', $entity);

        $map = $entity->child;
        $data = $request->validated();

        $config = $map->config ?? [];
        if (array_key_exists('distance_measure', $data)) {
            $config['distance_measure'] = $data['distance_measure'];
        }
        if (array_key_exists('distance_name', $data)) {
            $config['distance_name'] = $data['distance_name'];
        }
        unset($data['distance_measure'], $data['distance_name']);
        $data['config'] = $config;

        if (array_key_exists('center_marker_id', $data) && ! empty($data['center_marker_id'])) {
            $data['center_x'] = null;
            $data['center_y'] = null;
        } elseif (array_key_exists('center_x', $data) || array_key_exists('center_y', $data)) {
            $data['center_marker_id'] = null;
        }

        $map->update($data);

        return response()->json(new MapResource($map)->campaign($campaign));
    }
}
