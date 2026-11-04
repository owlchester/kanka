<div class="tab-pane flex flex-col gap-5 {{ request()->get('tab') == 'form-participants' ? 'active' : '' }}" id="form-participants">
    @inject('participantService', 'App\Services\Events\ParticipantService')
    @php
        $event = isset($model) && $model instanceof \App\Models\Event ? $model : new \App\Models\Event;
        $sourceEvent = isset($source) && $source instanceof \App\Models\Entity && $source->child instanceof \App\Models\Event ? $source->child : $event;
        $participantState = old('event_participants') !== null ? json_decode(old('event_participants'), true) : null;
        $hasOldParticipantState = is_array($participantState) && isset($participantState['groups'], $participantState['participants'], $participantState['revision']);
        if (!$hasOldParticipantState) {
            $participantState = $participantService->state($sourceEvent);
        }
        if ($sourceEvent !== $event && !$hasOldParticipantState) {
            $keys = [];
            foreach ($participantState['groups'] as $position => &$group) {
                $oldKey = $group['key'];
                $group['key'] = 'new-copy-'.$position;
                $keys[$oldKey] = $group['key'];
            }
            unset($group);
            foreach ($participantState['participants'] as &$participant) {
                if ($participant['group'] !== null) {
                    $participant['group'] = $keys[$participant['group']] ?? null;
                }
            }
            unset($participant);
            $participantState['revision'] = $participantService->state($event)['revision'];
        }
    @endphp
    @include('events.participants._manager', ['staged' => true])
</div>
