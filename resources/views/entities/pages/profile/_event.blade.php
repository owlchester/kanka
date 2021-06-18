<?php /** @var \App\Models\Event $model */

?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p class="entity-type">
                        <b>{{ __('events.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->location)
                    <p class="entity-location" data-foreign="{{ $model->location_id }}">
                        <b>{{ __('events.fields.location') }}</b><br />
                        {!! $model->location->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->date)
                    <p class="entity-date">
                        <b>{{ __('events.fields.date') }}</b><br />
                        {{ $model->date }}
                    </p>
                @endif
                @if ($model->event)
                    <p class="entity-event" data-foreign="{{ $model->event_id }}">
                        <b>{{ __('events.fields.event') }}</b><br />
                        {!! $model->event->tooltipedLink() !!}
                    </p>
                @endif
                @if ($campaign->enabled('characters') && $model->character)
                    <p class="entity-character" data-foreign="{{ $model->character_id }}">
                        <b>{{ __('events.fields.character') }}</b><br />
                        {!! $model->character->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
