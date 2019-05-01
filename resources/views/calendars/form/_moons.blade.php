<?php /** @var \App\Models\Calendar $model */?>
<p class="help-block">{{ __('calendars.hints.moons') }}</p>
<div class="form-group">
    <div class="row">
        <div class="col-md-8">{{ __('calendars.parameters.moon.name') }}</div>
        <div class="col-md-2">{{ __('calendars.parameters.moon.fullmoon') }}</div>
        <div class="col-md-2">{{ __('calendars.parameters.moon.offset') }}</div>
    </div>
</div>
<?php
$moons = [];
$names = old('moon_name');
$fullmoons = old('moon_fullmoon');
$moonoffsets = old('moon_offset');
if (!empty($names)) {
    $cpt = 0;
    foreach ($names as $name) {
        if (!empty($name) || !empty($fullmoons[$cpt])) {
            $moons[] = [
                'name' => $name,
                'length' => $fullmoons[$cpt],
                'offset' => $moonoffsets[$cpt]
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
    @foreach ($moons as $fullmoon => $moon)
        <div class="form-group">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-arrows-alt-v"></span>
                        </span>
                        {!! Form::text('moon_name[]', $moon, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        {!! Form::number('moon_fullmoon[]', $fullmoon, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        {!! Form::number('moon_offset[]', $fullmoon, ['class' => 'form-control']) !!}
                        <span class="input-group-btn">
                            <span class="month-delete btn btn-danger" data-remove="4" title="{{ __('crud.remove') }}">
                                <i class="fa fa-trash"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<a class="btn btn-default" id="add_moon" href="#" title="{{ __('calendars.actions.add_moon') }}">
    <i class="fa fa-plus"></i> {{ __('calendars.actions.add_moon') }}
</a>

<div class="form-group" id="template_moon" style="display: none">
    <div class="row">
        <div class="col-md-9">
            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fa fa-arrows-alt-v"></span>
                                </span>
                {!! Form::text('moon_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.moon.name')]) !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group">
                {!! Form::number('moon_fullmoon[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.moon.fullmoon')]) !!}
                <span class="input-group-btn">
                                    <span class="month-delete btn btn-danger" data-remove="4" title="{{ __('crud.remove') }}">
                                        <i class="fa fa-trash"></i>
                                    </span>
                                </span>
            </div>
        </div>
    </div>
</div>