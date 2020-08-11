@inject('random', 'App\Services\RandomCharacterService')

<?php // Dirty hack to know if we need the prefill or the random generator
/**
 * @var \App\Services\RandomCharacterService $random
 */
$isRandom = false;
if (request()->route()->getName() == 'characters.random') {
    $isRandom = true;
}
?>

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'characters'])
        @include('cruds.fields.title')
        @include('cruds.fields.family')
        @include('cruds.fields.race')
        @include('cruds.fields.location')
        @include('cruds.fields.tags')
        @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])
        <div class="form-group">
            <label>{{ trans('characters.fields.age') }}</label>
            {!! Form::text('age', ($isRandom ? $random->generateNumber(1, 300) : FormCopy::field('age')->string()), ['placeholder' => trans('characters.placeholders.age'), 'class' => 'form-control', 'maxlength' => 25]) !!}
            <p class="help-block">{!! __('characters.helpers.age', ['more' => link_to_route('helpers.age', __('crud.actions.find_out_more'))]) !!}</p>
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.sex') }}</label>
            {!! Form::text('sex', ($isRandom ? $random->generate('sex') : FormCopy::field('sex')->string()), [
                'placeholder' => trans('characters.placeholders.sex'),
                'class' => 'form-control',
                'maxlength' => 45,
                'list' => 'character-gender-list',
                'autocomplete' => 'off'
            ]) !!}
        </div>

        <div class="hidden">
            <datalist id="character-gender-list">
                @foreach (\App\Facades\CharacterCache::genderSuggestion() as $gender)
                    <option value="{{ $gender }}">{{ $gender }}</option>
                @endforeach
            </datalist>
        </div>


        <div class="form-group">
            {!! Form::hidden('is_dead', 0) !!}
            <label>{!! Form::checkbox('is_dead', 1, (!empty($model) ? $model->is_dead : ($isRandom ? $random->generateBool(10) : (!empty($source) ? FormCopy::field('is_dead')->boolean() : 0)))) !!}
                {{ trans('characters.fields.is_dead') }}
            </label>
            <p class="help-block">{{ trans('characters.hints.is_dead') }}</p>
        </div>

        @include('cruds.fields.private')
    </div>

    <div class="col-md-6">
        @include('cruds.fields.entry2')

        @include('cruds.fields.image')
    </div>
</div>

