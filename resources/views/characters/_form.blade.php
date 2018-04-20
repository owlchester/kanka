@inject('location', 'App\Services\LocationService')
@inject('random', 'App\Services\RandomCharacterService')
@inject('formService', 'App\Services\FormService')

<?php // Dirty hack to know if we need the prefill or the random generator
$isRandom = false;
if (request()->route()->getName() == 'characters.random') {
    $isRandom = true;
}
?>

{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.general_information') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ trans('characters.fields.name') }}</label>
                    {!! Form::text('name', ($isRandom ? $random->generate('name') : $formService->prefill('name', $source)), ['placeholder' => trans('characters.fields.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.title') }}</label>
                    {!! Form::text('title', ($isRandom ? $random->generate('title') : $formService->prefill('title', $source)), ['placeholder' => trans('characters.placeholders.title'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                @if ($campaign->enabled('families'))
                <div class="form-group">
                    {!! Form::select2(
                        'family_id',
                        (isset($model) && $model->family ? $model->family : $formService->prefillSelect('family', $source)),
                        App\Models\Family::class,
                        true
                    ) !!}
                </div>
                @endif
                @if ($campaign->enabled('locations'))
                <div class="form-group">
                    {!! Form::select2(
                        'location_id',
                        (isset($model) && $model->location ? $model->location : $formService->prefillSelect('location', $source)),
                        App\Models\Location::class,
                        true
                    ) !!}
                </div>
                @endif
                <div class="form-group">
                    <label>{{ trans('characters.fields.race') }}</label>
                    {!! Form::text('race', ($isRandom ? $random->generate('race') : $formService->prefill('race', $source)), ['placeholder' => trans('characters.placeholders.race'), 'class' => 'form-control', 'maxlength' => 45]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.type') }}</label>
                    {!! Form::text('type', ($isRandom ? $random->generate('type') : $formService->prefill('type', $source)), ['placeholder' => trans('characters.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>

                @if (Auth::user()->isAdmin())
                <div class="form-group">
                    {!! Form::hidden('is_private', 0) !!}
                    <label>{!! Form::checkbox('is_private', 1, $formService->prefill('is_private', $source)) !!}
                        {{ trans('crud.fields.is_private') }}
                    </label>
                    <p class="help-block">{{ trans('crud.hints.is_private') }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.appearance') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('characters.fields.age') }}</label>
                    {!! Form::text('age', ($isRandom ? $random->generateNumber(1, 300) : $formService->prefill('age', $source)), ['placeholder' => trans('characters.placeholders.age'), 'class' => 'form-control', 'maxlength' => 25]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.sex') }}</label>
                    {!! Form::text('sex', ($isRandom ? $random->generate('sex') : $formService->prefill('sex', $source)), ['placeholder' => trans('characters.placeholders.sex'), 'class' => 'form-control', 'maxlength' => 10]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.height') }}</label>
                    {!! Form::text('height', ($isRandom ? $random->generateNumber('height') : $formService->prefill('height', $source)), ['placeholder' => trans('characters.placeholders.height'), 'class' => 'form-control', 'maxlength' => 10]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.weight') }}</label>
                    {!! Form::text('weight', ($isRandom ? $random->generateNumber('weight') : $formService->prefill('weight', $source)), ['placeholder' => trans('characters.placeholders.weight'), 'class' => 'form-control', 'maxlength' => 10]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.eye') }}</label>
                    {!! Form::text('eye_colour', ($isRandom ? $random->generate('eye') : $formService->prefill('eye_colour', $source)), ['placeholder' => trans('characters.placeholders.eye'), 'class' => 'form-control', 'maxlength' => 12]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.hair') }}</label>
                    {!! Form::text('hair', ($isRandom ? $random->generate('hair') : $formService->prefill('hair', $source)), ['placeholder' => trans('characters.placeholders.hair'), 'class' => 'form-control', 'maxlength' => 45]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.skin') }}</label>
                    {!! Form::text('skin', ($isRandom ? $random->generate('skin') : $formService->prefill('skin', $source)), ['placeholder' => trans('characters.placeholders.skin'), 'class' => 'form-control', 'maxlength' => 45]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.languages') }}</label>
                    {!! Form::text('languages', ($isRandom ? $random->generate('language', 3) : $formService->prefill('languages', $source)), ['placeholder' => trans('characters.placeholders.languages'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>

                @include('cruds.fields.image')
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.history') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('characters.fields.history') }}</label>
                    {!! Form::textarea('history', $formService->prefill('history', $source), ['placeholder' => trans('characters.placeholders.history'), 'class' => 'form-control html-editor', 'id' => 'history']) !!}
                </div>
                <div class="form-group">
                    <a href="{{ route('helpers.link') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('characters.sections.personality') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('characters.fields.traits') }}</label>
                    {!! Form::textarea('traits', ($isRandom ? $random->generate('trait') : $formService->prefill('traits', $source)), ['placeholder' => trans('characters.placeholders.traits'), 'class' => 'form-control', 'rows' => 4]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.goals') }}</label>
                    {!! Form::textarea('goals', ($isRandom ? $random->generate('goal') : $formService->prefill('goals', $source)), ['placeholder' => trans('characters.placeholders.goals'), 'class' => 'form-control', 'rows' => 4]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.fears') }}</label>
                    {!! Form::textarea('fears', ($isRandom ? $random->generate('fear') : $formService->prefill('fears', $source)), ['placeholder' => trans('characters.placeholders.fears'), 'class' => 'form-control', 'rows' => 4]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.mannerisms') }}</label>
                    {!! Form::textarea('mannerisms', ($isRandom ? $random->generate('mannerism') : $formService->prefill('mannerisms', $source)), ['placeholder' => trans('characters.placeholders.mannerisms'), 'class' => 'form-control', 'rows' => 4]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('characters.fields.free') }}</label>
                    {!! Form::textarea('free', $formService->prefill('free', $source), ['placeholder' => trans('characters.placeholders.free'), 'class' => 'form-control', 'rows' => 4]) !!}
                </div>
                <hr>
                <div class="form-group">
                    {!! Form::hidden('is_personality_visible', 0) !!}
                    <label>{!! Form::checkbox('is_personality_visible', 1, (!empty($model) ? $model->is_personality_visible : (!empty($source) ? $formService->prefill('is_personality_visible', $source) : 1))) !!}
                        {{ trans('characters.fields.is_personality_visible') }}
                    </label>
                    <p class="help-block">{{ trans('characters.hints.is_personality_visible') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <button class="btn btn-success">{{ trans('crud.save') }}</button>
        <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
    </div>
</div>
