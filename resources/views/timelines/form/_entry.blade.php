<?php /** @var \App\Models\Timeline $model */ ?>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'timelines'])
        @include('cruds.fields.type', ['base' => \App\Models\Timeline::class, 'trans' => 'timelines'])

        <div class="form-group">
        {!! Form::hidden('revert_order', 0) !!}
            <label>{!! Form::checkbox('revert_order') !!}
                {{ __('timelines.fields.reverse_order') }}
            </label>

            <p class="help-block">
                {!! __('timelines.helpers.reverse_order') !!}
            </p>
        </div>

        @include('cruds.fields.tags')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>
