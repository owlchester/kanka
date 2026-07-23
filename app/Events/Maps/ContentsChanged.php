<?php

namespace App\Events\Maps;

use App\Enums\Visibility;
use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Models\Map;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Broadcasting\ShouldRescue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContentsChanged implements ShouldBroadcastNow, ShouldRescue
{
    use Dispatchable;
    use InteractsWithBroadcasting;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public Map $map,
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
                ? new PrivateChannel('map.' . $this->map->id . '.admin')
                : new PresenceChannel('map.' . $this->map->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MapContentsChanged';
    }

    public function broadcastWith(): array
    {
        $groups = $this->map->groups();
        $layers = $this->map->layers();

        if ($this->includeRestricted) {
            // The acting user (whoever triggered the save) may not be an
            // admin — this channel must be complete regardless, so the
            // visibility scope is bypassed entirely rather than relied on.
            $groups->withPrivate();
            $layers->withPrivate();
        } else {
            $groups->whereIn('visibility_id', [Visibility::All, Visibility::Member]);
            $layers->whereIn('visibility_id', [Visibility::All, Visibility::Member]);
        }

        return [
            'groups' => GroupResource::collection($groups->get()),
            'layers' => LayerResource::collection(
                $layers->get()->filter(fn ($layer) => $layer->isExplorable())->values()
            ),
        ];
    }
}
