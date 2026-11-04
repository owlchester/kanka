<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveEventParticipants;
use App\Models\Campaign;
use App\Models\Event;
use App\Services\Events\ParticipantService;

class ParticipantManagerController extends Controller
{
    public function __construct(private ParticipantService $service) {}

    public function update(SaveEventParticipants $request, Campaign $campaign, Event $event)
    {
        return response()->json($this->service->save($event, $request->validated()));
    }
}
