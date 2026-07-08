<?php

namespace App\Events\Maps;

use App\Http\Resources\Maps\Explore\GroupResource;
use App\Models\MapGroup;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupChanged implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public MapGroup $group,
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
            new PresenceChannel('map.' . $this->group->map_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MapGroupChanged';
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'id' => $this->group->id,
            'group' => $this->action === 'deleted' ? null : new GroupResource($this->group),
        ];
    }
}
