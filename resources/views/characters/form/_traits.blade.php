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
        <label>{{ __('characters.sections.appearance') }}</label>
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
    </div>
    <div class="col-md-6">
        <label>{{ __('characters.sections.personality') }}</label>
        @if (!isset($model) || auth()->user()->can('personality', $model))
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
                                'rows' => 3
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
                            'rows' => 3
                        ]) !!}
                    </div>
                </div>
            </div>

            <hr>
            <div class="form-group">
                {!! Form::hidden('is_personality_visible', 0) !!}
                <label>{!! Form::checkbox('is_personality_visible', 1, (!empty($model) ? $model->is_personality_visible : (!empty($source) ? $formService->prefill('is_personality_visible', $source) : !CampaignLocalization::getCampaign()->entity_personality_visibility))) !!}
                    {{ trans('characters.fields.is_personality_visible') }}
                </label>
                <p class="help-block">{{ trans('characters.hints.is_personality_visible') }}</p>
            </div>
        @else
            <p class="alert alert-warning">{{ __('characters.warnings.personality_hidden') }}</p>
        @endif
    </div>
</div>