<?php /** @var \App\Models\Calendar $model */ ?>
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'calendars'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Calendar::class, 'trans' => 'calendars'])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ __('calendars.fields.current_year') }}</label>
                    {!! Form::number('current_year', !empty($model) ? $model->currentDate('year') : (isset($source) ? $source->currentDate('year') : null), ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::hidden('skip_year_zero', 0) !!}
                    <label>
                        {!! Form::checkbox('skip_year_zero', 1, !empty($model) ? $model->skip_year_zero : 0) !!}
                        {{ __('calendars.fields.skip_year_zero') }}
                        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('calendars.hints.skip_year_zero') }}" data-toggle="tooltip"></i>
                    </label>
                    <p class="help-block visible-xs visible-sm">{{ __('calendars.hints.skip_year_zero') }}</p>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-group">
                    <label>{{ __('calendars.fields.current_month') }}</label>
                    {!! Form::number('current_month', !empty($model) ? $model->currentDate('month') : (isset($source) ? $source->currentDate('month') : null), ['class' => 'form-control', 'min' => 1]) !!}
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-group">
                    <label>{{ __('calendars.fields.current_day') }}</label>
                    {!! Form::number('current_day', !empty($model) ? $model->currentDate('date') : (isset($source) ? $source->currentDate('date') : null), ['class' => 'form-control', 'min' => 1]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('calendars.fields.suffix') }}</label>
            {!! Form::text('suffix', FormCopy::field('suffix')->string(), ['placeholder' => __('calendars.placeholders.suffix'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
    </div>
</div>

@include('cruds.fields.entry2')

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>

@if (request()->has('redirect'))
    {!! Form::hidden('redirect', request()->get('redirect')) !!}
@endif

@section('scripts')
    @parent
    <script src="{{ mix('js/forms/calendar.js') }}" defer></script>
@endsection
