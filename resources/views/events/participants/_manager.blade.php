<div class="js-event-participants">
    <script type="application/json" class="js-participant-config">{!! json_encode([
        'initial' => $participantState,
        'editable' => $staged || (auth()->check() && auth()->user()->can('update', $entity)),
        'staged' => $staged,
        'saveUrl' => isset($event) && $event->exists ? route('events.participants.update', [$campaign, $event]) : null,
        'searchUrl' => route('search.live', [$campaign]),
        'labels' => __('events.participants'),
    ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
    <div class="js-participant-app"><p class="text-sm opacity-70" role="status">{{ __('events.participants.loading') }}</p></div>
</div>
