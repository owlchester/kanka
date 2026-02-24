<?php

namespace App\Events;

use App\Models\SpotlightContent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SpotlightSubmitted
{
    use Dispatchable,  SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public SpotlightContent $spotlightContent)
    {
        //
    }
}
