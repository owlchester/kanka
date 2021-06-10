<?php /** @var \App\Models\Timeline $model */

?>
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p>
                        <b>{{ __('timelines.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->timeline)
                    <p>
                        <b>{{ __('timelines.fields.timeline') }}</b><br />
                        {!! $model->timeline->tooltipedLink() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
