<?php /** @var \App\Models\Calendar $model */?>
<p class="help-block">{{ __('calendars.hints.moons') }}</p>
<div class="form-group">
    <div class="row">
        <div class="col-md-6">{{ __('calendars.parameters.moon.name') }}</div>
        <div class="col-md-2">{{ __('calendars.parameters.moon.fullmoon') }}</div>
        <div class="col-md-2">{{ __('crud.fields.colour') }}</div>
        <div class="col-md-2">{{ __('calendars.parameters.moon.offset') }}
        <i class="fas fa-question-circle hidden-xs hidden-sm" data-placement="left" data-toggle="tooltip" title="{{ __('calendars.helpers.moon_offset') }}"></i>
        </div>
    </div>
</div>
<?php
$moons = [];
$moonNames = old('moon_name');
$moonFullmoons = old('moon_fullmoon');
$moonOffsets = old('moon_offset');
$moonColours = old('moon_colour');
$moonIds = old('moon_id');
if (!empty($moonNames)) {
    $cpt = 0;
    foreach ($moonNames as $name) {
        if (!empty($name) || !empty($moonFullmoons[$cpt])) {
            $moons[] = [
                'name' => $name,
                'fullmoon' => $moonFullmoons[$cpt],
                'offset' => $moonOffsets[$cpt],
                'colour' => $moonColours[$cpt],
                'id' => $moonIds[$cpt],
            ];
        }
        $cpt++;
    }
} elseif (isset($model)) {
    $moons = $model->moons();
} elseif (isset($source)) {
    $moons = $source->moons();
}?>
<div class="calendar-moons">
    @foreach ($moons as $fullmoon)
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-arrows-alt-v"></span>
                        </span>
                        {!! Form::text('moon_name[]', $fullmoon['name'], ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    {!! Form::number('moon_fullmoon[]', $fullmoon['fullmoon'], ['class' => 'form-control', 'step' => '0.01', 'min' => 1]) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::select('moon_colour[]', \App\Facades\FormCopy::colours(false), \Illuminate\Support\Arr::get($fullmoon, 'colour', 'grey'), ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        {!! Form::number('moon_offset[]', $fullmoon['offset'], ['class' => 'form-control']) !!}
                        <span class="input-group-btn">
                            <span class="month-delete btn btn-danger" data-remove="4" title="{{ __('crud.remove') }}">
                                <i class="fa fa-trash"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::hidden('moon_id[]', $fullmoon['id']) !!}
    @endforeach
</div>
<a class="btn btn-default" id="add_moon" href="#" title="{{ __('calendars.actions.add_moon') }}">
    <i class="fa fa-plus"></i> {{ __('calendars.actions.add_moon') }}
</a>

@section('modals')
    @parent
<div class="form-group" id="template_moon" style="display: none">
    <div class="row">
        <div class="col-md-6">
            {!! Form::text('moon_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.moon.name')]) !!}
        </div>
        <div class="col-md-2">
            {!! Form::number('moon_fullmoon[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.moon.fullmoon'), 'step' => '0.01', 'min' => 1]) !!}
        </div>
        <div class="col-md-2">
            {!! Form::select('moon_colour[]', \App\Facades\FormCopy::colours(false), 'grey', ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-2">
            <div class="input-group">
                {!! Form::number('moon_offset[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.moon.offset')]) !!}
                <span class="input-group-btn">
                    <span class="month-delete btn btn-danger" data-remove="4" title="{{ __('crud.remove') }}">
                        <i class="fa fa-trash"></i>
                    </span>
                </span>
            </div>
        </div>
    </div>
    {!! Form::hidden('moon_id[]', null) !!}
</div>
@endsection
