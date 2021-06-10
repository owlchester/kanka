<?php /** @var \App\Models\Tag $model */

?>
@inject('dateRenderer', 'App\Renderers\DateRenderer')


<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->type)
                    <p>
                        <b>{{ trans('tags.fields.type') }}</b><br />
                        {{ $model->type }}
                    </p>
                @endif
                @if ($model->hasColour())
                    <p>
                        <b>{{ trans('calendars.fields.colour') }}</b><br />
                        <span class="{{ $model->colourClass() }}">{{ __('colours.' . $model->colour) }}</span>
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
