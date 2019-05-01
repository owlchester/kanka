@inject('random', 'App\Services\RandomCharacterService')

<?php // Dirty hack to know if we need the prefill or the random generator
/**
 * @var \App\Services\RandomCharacterService $random
 * @var \App\Services\FormService $formService
 */
$isRandom = false;
if (request()->route()->getName() == 'characters.random') {
    $isRandom = true;
}
?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('characters.fields.name') }}</label>
            {!! Form::text('name', ($isRandom ? $random->generate('name') : $formService->prefill('name', $source)), ['placeholder' => trans('characters.fields.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.title') }}</label>
            {!! Form::text('title', ($isRandom ? $random->generate('title') : $formService->prefill('title', $source)), ['placeholder' => trans('characters.placeholders.title'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.family')
        @include('cruds.fields.race')
        @include('cruds.fields.location')
        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')
        @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])
        <div class="form-group">
            <label>{{ trans('characters.fields.age') }}</label>
            {!! Form::text('age', ($isRandom ? $random->generateNumber(1, 300) : $formService->prefill('age', $source)), ['placeholder' => trans('characters.placeholders.age'), 'class' => 'form-control', 'maxlength' => 25]) !!}
        </div>
        <div class="form-group">
            <label>{{ trans('characters.fields.sex') }}</label>
            {!! Form::text('sex', ($isRandom ? $random->generate('sex') : $formService->prefill('sex', $source)), ['placeholder' => trans('characters.placeholders.sex'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>

        <div class="form-group">
            {!! Form::hidden('is_dead', 0) !!}
            <label>{!! Form::checkbox('is_dead', 1, (!empty($model) ? $model->is_dead : ($isRandom ? $random->generateBool(10) : (!empty($source) ? $formService->prefill('is_dead', $source) : 0)))) !!}
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

