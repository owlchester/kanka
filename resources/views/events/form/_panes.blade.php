<div class="tab-pane flex flex-col gap-5 {{ request()->get('tab') == 'form-participants' ? 'active' : '' }}" id="form-participants">
    @inject('participantService', 'App\Services\Events\ParticipantService')
    @php
        $event = isset($model) && $model instanceof \App\Models\Event ? $model : new \App\Models\Event;
        $participantState = old('event_participants') ? json_decode(old('event_participants'), true) : null;
        if (!is_array($participantState) || !isset($participantState['groups'], $participantState['participants'], $participantState['revision'])) {
            $participantState = $participantService->state($event);
        }
    @endphp
    @include('events.participants._manager', ['staged' => true])
</div>
