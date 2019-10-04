<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'dice_rolls'])
        @if ($campaign->enabled('characters'))
            <div class="form-group">
                {!! Form::select2(
                    'character_id',
                    (isset($model) && $model->character ? $model->character : FormCopy::field('character')->select()),
                    App\Models\Character::class,
                    true
                ) !!}
            </div>
        @endif
        @include('cruds.fields.tags')

        <div class="form-group required">
            <label>{{ trans('dice_rolls.fields.parameters') }}</label>
            {!! Form::text('parameters', FormCopy::field('parameters')->string(), ['placeholder' => trans('dice_rolls.placeholders.parameters'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            <a href="{{ route('helpers.dice') }}" target="_blank">{{ trans('dice_rolls.hints.parameters') }}</a>
        </div>

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>