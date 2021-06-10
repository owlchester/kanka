<?php /** @var \App\Models\Family $model */

?>
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">

                    @if ($model->type)
                        <p>
                            <b>{{ trans('calendars.fields.type') }}</b><br />
                            {{ $model->type }}
                        </p>
                    @endif
                    @if ($model->suffix)
                        <p>
                            <b>{{ trans('calendars.fields.suffix') }}</b><br />
                            {{ $model->suffix }}
                        </p>
                    @endif
                    @if ($model->date)
                        <p>
                            <b>{{ trans('calendars.fields.date') }}</b><br />
                            {{ $model->niceDate() }}
                        </p>
                    @endif
                    @if ($model->calendar)
                        <p>
                            <b>{{ trans('calendars.fields.calendar') }}</b><br />
                            {!! $model->calendar->tooltipedLink() !!}
                        </p>
                    @endif
            </div>
        </div>
    </div>
</div>
