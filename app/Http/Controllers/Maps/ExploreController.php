<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Models\MapMarker;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ExploreController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct()
    {
        $this->middleware('adless');
    }

    /**
     * Exploration view for a map
     */
    public function index(Campaign $campaign, Map $map)
    {
        if (empty($map->entity)) {
            abort(404);
        }
        $this->campaign($campaign)->authEntityView($map->entity);

        if (!$map->explorable()) {
            return redirect()
                ->route('entities.show', [$campaign, $map->entity])
                ->withError(__('maps.errors.explore.missing'));
        }
        if ($map->isChunked()) {
            if ($map->chunkingError()) {
                return redirect()
                    ->route('entities.show', [$campaign, $map->entity])
                ;
            } elseif (!$map->chunkingReady()) {
                return redirect()
                    ->route('entities.show', [$campaign, $map->entity])
                ;
            }
        }
        return view('maps.explore')
            ->with('map', $map)
            ->with('campaign', $campaign)
        ;
    }

    /**
     * Map ticker for updates to pointers
     */
    public function ticker(Campaign $campaign, Map $map)
    {
        $this->campaign($campaign)->authEntityView($map->entity);

        $timestamp = request()->get('ts', time());
        /** @var MapMarker[] $markers */
        $markers = $map->markers()->where('updated_at', '>=', $timestamp)->get();
        $data = [];
        foreach ($markers as $marker) {
            $data[] = [
                'id' => $marker->id,
                'longitude' => $marker->longitude,
                'latitude' => $marker->latitude,
            ];
        }

        return response()->json([
            'ts' => Carbon::now(),
            'markers' => $data,
        ]);
    }

    /**
     * Load only a chunk of the map and cache it for the user
     */
    public function chunks(Campaign $campaign, Map $map)
    {
        $headers = ['Expires', Carbon::now()->addDays(1)->toDateTimeString()];
        if (!request()->has(['z', 'x', 'y'])) {
            return response()
                ->file(public_path('/images/map_chunks/transparent.png'), $headers);
        }

        $path = 'maps/' . $map->id . '/chunks/' . request()->get('z')
            . '/' . request()->get('x') . '_' . request()->get('y')
            . '.png'
        ;

        if (!Storage::exists($path)) {
            return response()
                ->file(public_path('/images/map_chunks/transparent.png'), $headers);
        }

        return redirect()->to(Storage::url($path));
        //return response()
        //    ->file(Storage::path($path), $headers);
    }
}
