<?php

namespace App\Console\Commands;

use App\Events\WhiteboardUpdated;
use Illuminate\Console\Command;

class TestWhiteboards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:whiteboards {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a websocket test event to a given whiteboard ID';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = (int) $this->argument('id');

        broadcast(new WhiteboardUpdated($id, [
            'test' => true,
            'message' => "Test event sent to whiteboard {$id}",
        ]));

        $this->info("Broadcasted test event to whiteboard.{$id}");

        return Command::SUCCESS;
    }
}
