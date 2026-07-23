<?php

namespace App\Events\Maps;

use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\MapMarker;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MarkerChanged implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public MapMarker $marker,
        public string $action,
        public bool $includeRestricted = false,
    ) {
        $this->broadcastVia('reverb');
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            $this->includeRestricted
                ? new PrivateChannel('map.' . $this->marker->map_id . '.admin')
                : new PresenceChannel('map.' . $this->marker->map_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MapMarkerChanged';
    }

    public function broadcastWith(): array
    {
        $action = $this->action;

        if (! $this->includeRestricted && $action !== 'deleted' && ! $this->marker->isPubliclyVisible()) {
            $action = 'deleted';
        }

        $map = $this->marker->map;

        return [
            'action' => $action,
            'id' => $this->marker->id,
            'pin' => $action === 'deleted'
                ? null
                : new PinResource($this->marker)->campaign($map->campaign)->mapEntity($map->entity),
        ];
    }
}
