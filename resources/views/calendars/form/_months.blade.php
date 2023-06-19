<?php /** @var \App\Models\Calendar $model */?>
<div class="field-months mb-2 required">
    <label>{{ __('calendars.fields.months') }}</label>
    <p class="help-block">{{ __('calendars.hints.months') }}</p>
    <input type="hidden" name="month_name" />
</div>
<div class="grid gap-2 grid-cols-2 md:grid-cols-4 md:gap-4 mb-2">
    <div class="">{{ __('calendars.parameters.month.name') }}</div>
    <div class="">{{ __('calendars.parameters.month.length') }}</div>
    <div class="">{{ __('calendars.parameters.month.alias') }}</div>
    <div class="">{{ __('calendars.parameters.month.type') }} <i class="fa-solid fa-question-circle" data-toggle="tooltip" title="{{ __('calendars.helpers.month_type') }}"></i></div>
</div>
<?php
$months = [];
$names = old('month_name');
$lengths = old('month_length');
$aliases = old('month_alias');
$types = old('month_type');
if (!empty($names)) {
    $cpt = 0;
    foreach ($names as $name) {
        if (!empty($name) || !empty($lengths[$cpt])) {
            $months[] = [
                'name' => $name,
                'length' => $lengths[$cpt],
                'alias' => $aliases[$cpt],
                'type' => $types[$cpt],
            ];
        }
        $cpt++;
    }
} elseif (isset($model)) {
    $months = $model->months();
} elseif (isset($source)) {
    $months = $source->months();
}?>
<div class="calendar-months sortable-elements">
    @foreach ($months as $month)
        <div class="parent-delete-row">
            <div class="grid gap-2 grid-cols-2 md:grid-cols-4 md:gap-4 mb-2">
                <div class="flex items-center gap-2">
                    <div class="sortable-handler p-2 cursor-move">
                        <x-icon class="fa-solid fa-grip-vertical" />
                    </div>
                    <div>
                        <label class="sr-only">{{ __('calendars.parameters.month.name') }}</label>
                        {!! Form::text('month_name[]', $month['name'], ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div>
                    <label class="sr-only">{{ __('calendars.parameters.month.length') }}</label>
                    {!! Form::number('month_length[]', $month['length'], [
                        'class' => 'form-control',
                        'maxlength' => 4,
                        'aria-label' => __('calendars.parameters.month.length'),
                    ]) !!}
                </div>

                <div>
                    <label class="sr-only">{{ __('calendars.parameters.month.alias') }}</label>
                    {!! Form::text('month_alias[]', \Illuminate\Support\Arr::get($month, 'alias', ''), [
                        'class' => 'form-control',
                        'maxlength' => 191,
                        'placeholder' => __('calendars.parameters.month.alias'),
                        'aria-label' => __('calendars.parameters.month.name'),
                    ]) !!}
                </div>

                <div class="flex items-center gap-2">
                    <div>
                        <label class="sr-only">{{ __('calendars.parameters.month.type') }}</label>
                        {!! Form::select('month_type[]', __('calendars.month_types'), (!empty($month['type']) ? $month['type'] : 'standard'), [
                            'class' => 'form-control',
                            'aria-label' => __('calendars.parameters.month.type'),
                        ]) !!}
                    </div>
                    <div class="">
                        <span class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" data-remove="4" title="{{ __('crud.remove') }}">
                            <x-icon class="trash"></x-icon>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<button class="btn2 btn-sm dynamic-row-add" data-template="template_month" data-target="calendar-months" title="{{ __('calendars.actions.add_month') }}">
    <x-icon class="plus"></x-icon> {{ __('calendars.actions.add_month') }}
</button>

@section('modals')
    @parent
<div id="template_month" style="display: none">
    <div class="parent-delete-row">
        <div class="grid gap-2 grid-cols-2 md:grid-cols-4 md:gap-4 mb-2">
            <div class="flex gap-2 items-center">
                <div class="sortable-handler p-2 cursor-move">
                    <x-icon class="fa-solid fa-grip-vertical" />
                </div>
                <div>
                    <label class="sr-only">{{ __('calendars.parameters.month.name') }}</label>
                    {!! Form::text('month_name[]', null, [
                        'class' => 'form-control',
                        'placeholder' => __('calendars.parameters.month.name'),
                        'aria-label' => __('calendars.parameters.month.name'),
                    ]) !!}
                </div>
            </div>
            <div>
                <label class="sr-only">{{ __('calendars.parameters.month.length') }}</label>
                {!! Form::number('month_length[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.month.length'),
                        'aria-label' => __('calendars.parameters.month.length'),]) !!}
            </div>
            <div>
                <label class="sr-only">{{ __('calendars.parameters.month.alias') }}</label>
                {!! Form::text('month_alias[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.month.alias'),
                        'aria-label' => __('calendars.parameters.month.alias'),]) !!}
            </div>
            <div class="flex gap-2 items-center">
                <div>
                <label class="sr-only">{{ __('calendars.parameters.month.type') }}</label>
                {!! Form::select('month_type[]', __('calendars.month_types'), 'standard', ['class' => 'form-control',
                    'aria-label' => __('calendars.parameters.month.type'),]) !!}
                </div>
                <div class="">
                    <span class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" data-remove="4" title="{{ __('crud.remove') }}">
                        <x-icon class="trash"></x-icon>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
