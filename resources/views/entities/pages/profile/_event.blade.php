<?php /** @var \App\Models\Event $model */

?>
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p>
                        <b>{{ __('events.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->location)
                    <p>
                        <b>{{ __('events.fields.location') }}</b><br />
                        {!! $model->location->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->date)
                    <p>
                        <b>{{ __('events.fields.date') }}</b><br />
                        {{ $model->date }}
                    </p>
                @endif
                @if ($model->event)
                    <p>
                        <b>{{ __('events.fields.event') }}</b><br />
                        {!! $model->event->tooltipedLink() !!}
                    </p>
                @endif
                @if ($campaign->enabled('characters') && $model->character)
                    <p>
                        <b>{{ __('events.fields.character') }}</b><br />
                        {!! $model->character->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
