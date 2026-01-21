<?php

namespace App\Events\Whiteboards;

use App\Http\Resources\Whiteboards\ShapeResource;
use App\Models\Whiteboard;
use App\Models\WhiteboardShape;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class Updated implements ShouldBroadcastNow
{
    use InteractsWithBroadcasting;
    use SerializesModels;
    use Dispatchable;
    use InteractsWithSockets;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Whiteboard $whiteboard,
        public string $action,
        public WhiteboardShape $shape
    )
    {
        $this->broadcastVia('reverb');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel("whiteboard.{$this->whiteboard->id}"),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'shape.created';
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'shape' => new ShapeResource($this->shape),
        ];
    }
}
