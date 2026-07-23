<?php

namespace App\Events\Maps;

use App\Models\Image;
use App\Models\Map;
use App\Models\MapLayer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TilingChanged implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public int $mapId,
        public string $status,
    ) {
        $this->broadcastVia('reverb');
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [new PresenceChannel('map.' . $this->mapId)];
    }

    public function broadcastAs(): string
    {
        return 'MapTilingChanged';
    }

    public function broadcastWith(): array
    {
        return ['status' => $this->status];
    }

    /**
     * Broadcast this image's tiling status to every map/layer currently referencing it.
     */
    public static function broadcastForImage(Image $image): void
    {
        $status = match (true) {
            $image->tilingRunning() => 'running',
            $image->tilingError() => 'error',
            default => 'finished',
        };

        $mapIds = Map::whereHas('entity', fn ($query) => $query->where('image_uuid', $image->id))
            ->pluck('id')
            ->merge(MapLayer::where('image_uuid', $image->id)->pluck('map_id'))
            ->unique();

        foreach ($mapIds as $mapId) {
            static::dispatch($mapId, $status);
        }
    }
}
