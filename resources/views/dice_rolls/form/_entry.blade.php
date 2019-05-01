<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('dice_rolls.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('dice_rolls.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>

        @if ($campaign->enabled('characters'))
            <div class="form-group">
                {!! Form::select2(
                    'character_id',
                    (isset($model) && $model->character ? $model->character : $formService->prefillSelect('character', $source)),
                    App\Models\Character::class,
                    true
                ) !!}
            </div>
        @endif
        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')

        <div class="form-group required">
            <label>{{ trans('dice_rolls.fields.parameters') }}</label>
            {!! Form::text('parameters', $formService->prefill('parameters', $source), ['placeholder' => trans('dice_rolls.placeholders.parameters'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            <a href="{{ route('helpers.dice') }}" target="_blank">{{ trans('dice_rolls.hints.parameters') }}</a>
        </div>

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>