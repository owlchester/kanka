<?php /** @var \App\Models\Calendar $model */

?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p class="entity-type">
                        <b>{{ trans('calendars.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->suffix)
                    <p class="entity-suffix">
                        <b>{{ trans('calendars.fields.suffix') }}</b><br />
                        {{ $model->suffix }}
                    </p>
                @endif
                @if ($model->date)
                    <p class="entity-date">
                        <b>{{ trans('calendars.fields.date') }}</b><br />
                        {{ $model->niceDate() }}
                    </p>
                @endif
                @if ($model->calendar)
                    <p class="entity-calendar" data-foreign="{{ $model->calendar_id }}">
                        <b>{{ trans('calendars.fields.calendar') }}</b><br />
                        {!! $model->calendar->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
