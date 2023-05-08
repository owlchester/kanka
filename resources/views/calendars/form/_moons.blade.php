<?php /** @var \App\Models\Calendar $model */?>
<p class="help-block">{{ __('calendars.hints.moons') }}</p>
<div class="form-group">
    <div class="row">
        <div class="col-md-6">{{ __('calendars.parameters.moon.name') }}</div>
        <div class="col-md-2">{{ __('calendars.parameters.moon.fullmoon') }}</div>
        <div class="col-md-2">{{ __('crud.fields.colour') }}</div>
        <div class="col-md-2">{{ __('calendars.parameters.moon.offset') }}
        <i class="fa-solid fa-question-circle hidden-xs hidden-sm" aria-hidden="true" data-placement="left" data-toggle="tooltip" title="{{ __('calendars.helpers.moon_offset') }}"></i>
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
<div class="calendar-moons sortable-elements" data-handle=".input-group-addon">
    @foreach ($moons as $fullmoon)
        <div class="form-group parent-delete-row">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa-solid fa-arrows-alt-v" aria-hidden="true"></span>
                        </span>
                        <label class="sr-only">{{ __('calendars.parameters.moon.name') }}</label>
                        {!! Form::text('moon_name[]', $fullmoon['name'], ['class' => 'form-control', 'aria-label' => __('calendars.parameters.moon.name')]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="sr-only">{{ __('calendars.parameters.moon.fullmoon') }}</label>
                    {!! Form::number('moon_fullmoon[]', $fullmoon['fullmoon'], ['class' => 'form-control', 'step' => '0.01', 'min' => 1, 'aria-label' => __('calendars.parameters.moon.fullmoon')]) !!}
                </div>
                <div class="col-md-2">
                    <label class="sr-only">{{ __('crud.fields.colour') }}</label>
                    {!! Form::select('moon_colour[]', \App\Facades\FormCopy::colours(false), \Illuminate\Support\Arr::get($fullmoon, 'colour', 'grey'), ['class' => 'form-control', 'aria-label' => __('crud.fields.colour')]) !!}
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <label class="sr-only">{{ __('calendars.parameters.moon.offset') }}</label>
                        {!! Form::number('moon_offset[]', $fullmoon['offset'], ['class' => 'form-control', 'aria-label' => __('calendars.parameters.moon.offset')]) !!}
                        <span class="input-group-btn">
                            <span class="dynamic-row-delete btn btn-danger" data-remove="4" title="{{ __('crud.remove') }}">
                                <x-icon class="trash"></x-icon>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::hidden('moon_id[]', $fullmoon['id']) !!}
    @endforeach
</div>
<a class="btn btn-default dynamic-row-add" data-template="template_moon" data-target="calendar-moons" href="#" title="{{ __('calendars.actions.add_moon') }}">
    <x-icon class="plus"></x-icon> {{ __('calendars.actions.add_moon') }}
</a>

@section('modals')
    @parent
<div id="template_moon" style="display: none">
    <div class="form-group parent-delete-row">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <span class="fa-solid fa-arrows-alt-v" aria-hidden="true"></span>
                    </span>
                    <label class="sr-only">{{ __('calendars.parameters.moon.name') }}</label>
                    {!! Form::text('moon_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.moon.name'), 'aria-label' => __('calendars.parameters.moon.name')]) !!}
                </div>
            </div>
            <div class="col-md-2">
                <label class="sr-only">{{ __('calendars.parameters.moon.fullmoon') }}</label>
                {!! Form::number('moon_fullmoon[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.moon.fullmoon'), 'step' => '0.01', 'min' => 1, 'aria-label' => __('calendars.parameters.moon.offset')]) !!}
            </div>
            <div class="col-md-2">
                <label class="sr-only">{{ __('crud.fields.colour') }}</label>
                {!! Form::select('moon_colour[]', \App\Facades\FormCopy::colours(false), 'grey', ['class' => 'form-control', 'aria-label' => __('crud.fields.colour')]) !!}
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <label class="sr-only">{{ __('calendars.parameters.moon.offset') }}</label>
                    {!! Form::number('moon_offset[]', 0, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.moon.offset'), 'aria-label' => __('calendars.parameters.moon.offset')]) !!}
                    <span class="input-group-btn">
                        <span class="dynamic-row-delete btn btn-danger" data-remove="4" title="{{ __('crud.remove') }}">
                            <x-icon class="trash"></x-icon>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        {!! Form::hidden('moon_id[]', null) !!}
    </div>
</div>
@endsection
