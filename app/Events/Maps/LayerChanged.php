<?php

namespace App\Events\Maps;

use App\Http\Resources\Maps\Explore\LayerResource;
use App\Models\MapLayer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LayerChanged implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public MapLayer $layer,
        public string $action,
    ) {
        $this->broadcastVia('reverb');
    }

    /**
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('map.' . $this->layer->map_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MapLayerChanged';
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'id' => $this->layer->id,
            'layer' => $this->action === 'deleted' ? null : new LayerResource($this->layer),
        ];
    }
}
