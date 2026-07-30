<?php

namespace App\Events\Maps;

use App\Http\Resources\Maps\Explore\MapResource;
use App\Models\Map;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Updated implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public Map $map,
    ) {
        $this->broadcastVia('reverb');
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('map.' . $this->map->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MapUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'map' => new MapResource($this->map)->campaign($this->map->campaign),
        ];
    }
}
