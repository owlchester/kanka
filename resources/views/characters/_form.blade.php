@inject('random', 'App\Services\RandomCharacterService')
@inject('formService', 'App\Services\FormService')

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
                @include('cruds.fields.family')
                @include('cruds.fields.race')
                @include('cruds.fields.location')
                @include('cruds.fields.tags')
                @include('cruds.fields.attribute_template')
                @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])

                <div class="form-group">
                    {!! Form::hidden('is_dead', 0) !!}
                    <label>{!! Form::checkbox('is_dead', 1, (!empty($model) ? $model->is_dead : ($isRandom ? $random->generateBool(10) : (!empty($source) ? $formService->prefill('is_dead', $source) : 0)))) !!}
                        {{ trans('characters.fields.is_dead') }}
                    </label>
                    <p class="help-block">{{ trans('characters.hints.is_dead') }}</p>
                </div>

                @if (Auth::user()->isAdmin())
                    <hr>
                    @include('cruds.fields.private')
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
                    {!! Form::text('sex', ($isRandom ? $random->generate('sex') : $formService->prefill('sex', $source)), ['placeholder' => trans('characters.placeholders.sex'), 'class' => 'form-control', 'maxlength' => 45]) !!}
                </div>

                <div class="character-appearance">
                    @foreach ((isset($model) ? $model->characterTraits()->appearance()->orderBy('default_order', 'ASC')->get() : ($isRandom ? $random->generateTraits() : $formService->prefillCharacterAppearance($source))) as $trait)
                        <div class="form-group parent-delete-row">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <div class="input-group">
                                    <span class="input-group-addon hidden-xs hidden-sm">
                                        <span class="fa fa-arrows-alt-v"></span>
                                    </span>
                                        {!! Form::text('appearance_name[' . $trait->id . ']', $trait->name, [
                                            'class' => 'form-control',
                                            'maxlength' => 191,
                                            'placeholder' => trans('characters.placeholders.appearance_name')
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <div class="input-group">
                                        {!! Form::text('appearance_entry[' . $trait->id . ']', $trait->entry, [
                                            'class' => 'form-control',
                                            'placeholder' => trans('characters.placeholders.appearance_entry')
                                        ]) !!}
                                        <span class="input-group-btn">
                                        <span class="personality-delete btn btn-danger" title="{{ trans('crud.remove') }}">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="btn btn-default btn-block" id="add_appearance" href="#" title="{{ trans('characters.actions.add_appearance') }}">
                    <i class="fa fa-plus"></i> {{ trans('characters.actions.add_appearance') }}
                </a>
                <div id="template_appearance" style="display: none">
                    <div class="form-group parent-delete-row">
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                <div class="input-group">
                                    <span class="input-group-addon hidden-xs hidden-sm">
                                        <span class="fa fa-arrows-alt-v"></span>
                                    </span>
                                    {!! Form::text('appearance_name[]', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('characters.placeholders.appearance_name')
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-8 col-xs-8">
                                <div class="input-group">
                                    {!! Form::text('appearance_entry[]', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('characters.placeholders.appearance_entry')
                                    ]) !!}
                                    <span class="input-group-btn">
                                        <span class="personality-delete btn btn-danger" title="{{ trans('crud.remove') }}">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group"><br /></div>

                @include('cruds.fields.image')
            </div>
        </div>
    </div>

    <div class="col-md-6">
        @include('cruds.fields.entry')
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('characters.sections.personality') }}</h4>
            </div>
            @if (!isset($model) || auth()->user()->can('personality', $model))
                <div class="panel-body">
                    <div class="character-personality">
                        @foreach ((isset($model) ? $model->characterTraits()->personality()->orderBy('default_order', 'ASC')->get() : ($isRandom ? $random->generateTraits(false) : $formService->prefillCharacterPersonality($source))) as $trait)
                            <div class="parent-delete-row margin-bottom">
                                <div class="form-group">
                                    <div class="input-group">
                                <span class="input-group-addon hidden-xs hidden-sm">
                                    <span class="fa fa-arrows-alt-v"></span>
                                </span>
                                        {!! Form::text('personality_name[' . $trait->id . ']', $trait->name, [
                                            'class' => 'form-control',
                                            'placeholder' => trans('characters.placeholders.personality_name')
                                        ]) !!}
                                        <span class="input-group-btn">
                                    <span class="personality-delete btn btn-danger" title="{{ trans('crud.remove') }}">
                                        <i class="fa fa-trash"></i>
                                    </span>
                                </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::textarea('personality_entry[' . $trait->id . ']', $trait->entry, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('characters.placeholders.personality_entry'),
                                        'rows' => 4
                                    ]) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="btn btn-default btn-block" id="add_personality" href="#" title="{{ trans('characters.actions.add_personality') }}">
                        <i class="fa fa-plus"></i> {{ trans('characters.actions.add_personality') }}
                    </a>
                    <div id="template_personality" style="display: none">
                        <div class="parent-delete-row margin-bottom">
                            <div class="form-group">
                                <div class="input-group">
                                <span class="input-group-addon hidden-xs hidden-sm">
                                    <span class="fa fa-arrows-alt-v"></span>
                                </span>
                                    {!! Form::text('personality_name[]', null, [
                                        'class' => 'form-control',
                                        'placeholder' => trans('characters.placeholders.personality_name')
                                    ]) !!}
                                    <span class="input-group-btn">
                                    <span class="personality-delete btn btn-danger" title="{{ trans('crud.remove') }}">
                                        <i class="fa fa-trash"></i>
                                    </span>
                                </span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::textarea('personality_entry[]', null, [
                                    'class' => 'form-control',
                                    'placeholder' => trans('characters.placeholders.personality_entry'),
                                    'rows' => 4
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        {!! Form::hidden('is_personality_visible', 0) !!}
                        <label>{!! Form::checkbox('is_personality_visible', 1, (!empty($model) ? $model->is_personality_visible : (!empty($source) ? $formService->prefill('is_personality_visible', $source) : !CampaignLocalization::getCampaign()->entity_personality_visibility))) !!}
                            {{ trans('characters.fields.is_personality_visible') }}
                        </label>
                        <p class="help-block">{{ trans('characters.hints.is_personality_visible') }}</p>
                    </div>
                </div>
            @else
                <div class="panel-body">
                    <p class="alert alert-warning">{{ __('characters.warnings.personality_hidden') }}</p>
                </div>
            @endif
        </div>
        @include('cruds.fields.copy')
    </div>
</div>

@include('cruds.fields.save')
