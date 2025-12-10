<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhiteboardUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithBroadcasting, InteractsWithSockets, SerializesModels;

    public int $whiteboardId;

    public array $payload;

    public function __construct(int $whiteboardId, array $payload = [])
    {
        $this->whiteboardId = $whiteboardId;
        $this->payload = $payload;
        $this->broadcastVia('pusher');
    }

    public function broadcastAs()
    {
        return 'WhiteboardUpdated';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('kanka-whiteboard-' . $this->whiteboardId),
        ];
    }
}
