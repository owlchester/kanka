<?php
$role = \App\Facades\CampaignCache::adminRole();
?>
<x-grid>
    <div>
        <label>{{ __('characters.sections.appearance') }}</label>
        <div class="character-appearance sortable-elements" data-handle=".sortable-handler">
            @foreach ((isset($model) ? $model->characterTraits()->appearance()->orderBy('default_order', 'ASC')->get() : FormCopy::characterAppearance()) as $trait)
                <x-grid css="parent-delete-row">
                    <div class="flex gap-1 items-center">
                        <div class="sortable-handler px-2 cursor-move">
                            <x-icon class="fa-solid fa-grip-vertical" />
                        </div>
                        <div class="grow">
                            <label class="sr-only">{{ __('characters.labels.appearance.name') }}</label>
                            {!! Form::text('appearance_name[' . $trait->id . ']', $trait->name, [
                                'class' => 'form-control',
                                'maxlength' => 191,
                                'placeholder' => __('characters.placeholders.appearance_name'),
                                'spellcheck' => 'true',
                                'aria-label' => __('characters.labels.appearance.name'),
                            ]) !!}
                        </div>
                    </div>
                    <div class="flex gap-1 items-center">
                        <div class="grow">
                            <label class="sr-only">{{ __('characters.labels.appearance.entry') }}</label>
                            {!! Form::text('appearance_entry[' . $trait->id . ']', $trait->entry, [
                                'class' => 'form-control',
                                'placeholder' => __('characters.placeholders.appearance_entry'),
                                'spellcheck' => 'true',
                                'aria-label' => __('characters.labels.appearance.entry'),
                            ]) !!}
                        </div>
                        <div class="dynamic-row-delete btn2 btn-sm btn-outline btn-error" title="{{ __('crud.remove') }}" role="button" tabindex="0">
                            <x-icon class="trash"></x-icon>
                            <span class="sr-only">{{ __('crud.remove') }}</span>
                        </div>
                    </div>
                </x-grid>
            @endforeach
        </div>
        <button class="btn2 btn-sm btn-block dynamic-row-add" data-template="template_appearance" data-target="character-appearance">
            <x-icon class="plus"></x-icon>
            {{ __('characters.actions.add_appearance') }}
        </button>

        <div class="field-appearance-pinned checkbox">
            {!! Form::hidden('is_appearance_pinned', 0) !!}
            <label>
                {!! Form::checkbox('is_appearance_pinned', 1, (!empty($model) ? $model->is_appearance_pinned : (!empty($source) ? FormCopy::field('is_appearance_pinned')->boolean() : null))) !!}
                {{ __('characters.fields.is_appearance_pinned') }}
            </label>
            <p class="help-block">
                {{ __('characters.hints.is_appearance_pinned') }}
            </p>
        </div>
    </div>
    <div>
        <label>{{ __('characters.sections.personality') }}</label>
        @if (!isset($model) || auth()->user()->can('personality', $model))
            <div class="character-personality sortable-elements" data-handle=".sortable-handler">
                @foreach ((isset($model) ? $model->characterTraits()->personality()->orderBy('default_order', 'ASC')->get() : FormCopy::characterPersonality()) as $trait)
                    <div class="grid grid-cols-1 gap-2 mb-4 parent-delete-row">
                        <div class="flex gap-1 items-center">
                            <div class="sortable-handler px-2 cursor-move">
                                <x-icon class="fa-solid fa-grip-vertical" />
                            </div>
                            <div class="grow">
                                <label class="sr-only">{{ __('characters.labels.personality.name') }}</label>
                                {!! Form::text('personality_name[' . $trait->id . ']', $trait->name, [
                                    'class' => 'form-control',
                                    'placeholder' => __('characters.placeholders.personality_name'),
                                    'spellcheck' => 'true',
                                    'aria-label' => __('characters.labels.personality.name'),
                                ]) !!}
                            </div>
                            <div class="dynamic-row-delete btn2 btn-error btn-sm btn-outline" role="button" tabindex="0" >
                                <x-icon class="trash"></x-icon>
                                <span class="sr-only">{{ __('crud.remove') }}</span>
                            </div>
                        </div>
                        <div class="field-personality-entry">
                            <label class="sr-only">{{ __('characters.labels.personality.entry') }}</label>
                            {!! Form::textarea('personality_entry[' . $trait->id . ']', $trait->entry, [
                                'class' => 'form-control',
                                'placeholder' => __('characters.placeholders.personality_entry'),
                                'spellcheck' => 'true',
                                'rows' => 3,
                                'aria-label' => __('characters.labels.personality.entry'),
                            ]) !!}
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="btn2 btn-sm btn-block dynamic-row-add" data-template="template_personality" data-target="character-personality">
                <x-icon class="plus"></x-icon>
                {{ __('characters.actions.add_personality') }}
            </button>


            <div class="field-personality-pinned checkbox">
                {!! Form::hidden('is_personality_pinned', 0) !!}
                <label>
                    {!! Form::checkbox('is_personality_pinned', 1, (!empty($model) ? $model->is_personality_pinned : (!empty($source) ? FormCopy::field('is_personality_pinned')->boolean() : null))) !!}
                    {{ __('characters.fields.is_personality_pinned') }}
                </label>
                <p class="help-block">
                    {{ __('characters.hints.is_personality_pinned') }}
                </p>
            </div>

        @if (auth()->user()->isAdmin())
                <hr>
                {!! Form::hidden('is_personality_visible', 0) !!}
                <div class="field-personality-visible checkbox">
                    <label>{!! Form::checkbox('is_personality_visible', 1, (!empty($model) ? $model->is_personality_visible : (!empty($source) ? FormCopy::field('is_personality_visible')->boolean() : !CampaignLocalization::getCampaign()->entity_personality_visibility))) !!}
                        {{ __('characters.fields.is_personality_visible') }}
                    </label>
                    <p class="help-block">
                        {!! __('characters.hints.is_personality_visible', [
        'admin' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')), null, ['target' => '_blank'])
]) !!}
                    </p>
                </div>
            @else
                {!! Form::hidden('is_personality_visible', 1) !!}
            @endif
        @else
            <x-alert type="warning">
                {{ __('characters.warnings.personality_hidden') }}
            </x-alert>
        @endif
    </div>
</x-grid>


@section('modals')
    @parent
    <div class="hidden">
        <div id="template_appearance">
            <x-grid css="parent-delete-row">
                <div class="flex gap-1 items-center">
                    <div class="sortable-handler px-2 cursor-move">
                        <x-icon class="fa-solid fa-grip-vertical" />
                    </div>
                    <div class="grow">
                        <label class="sr-only">{{ __('characters.labels.appearance.name') }}</label>
                        {!! Form::text('appearance_name[]', null, [
                            'class' => 'form-control',
                            'placeholder' => __('characters.placeholders.appearance_name'),
                            'spellcheck' => 'true',
                            'aria-label' => __('characters.labels.appearance.name'),
                        ]) !!}
                    </div>
                </div>
                <div class="flex gap-1 items-center">
                    <div class="grow">
                        <label class="sr-only">{{ __('characters.labels.appearance.entry') }}</label>
                        {!! Form::text('appearance_entry[]', null, [
                            'class' => 'form-control',
                            'placeholder' => __('characters.placeholders.appearance_entry'),
                            'spellcheck' => 'true',
                            'aria-label' => __('characters.labels.appearance.entry'),
                        ]) !!}
                    </div>
                    <div class="dynamic-row-delete btn2 btn-sm btn-error btn-outline" role="button" tabindex="0">
                        <x-icon class="trash"></x-icon>
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </div>
                </div>
            </x-grid>
        </div>
        <div id="template_personality">
            <div class="grid grid-cols-1 gap-2 mb-4 parent-delete-row">
                <div class="flex gap-1 items-center">
                    <div class="sortable-handler px-2 cursor-move">
                        <x-icon class="fa-solid fa-grip-vertical" />
                    </div>
                    <div class="grow">
                        <label class="sr-only">{{ __('characters.labels.personality.name') }}</label>
                        {!! Form::text('personality_name[]', null, [
                            'class' => 'form-control',
                            'placeholder' => __('characters.placeholders.personality_name'),
                            'spellcheck' => 'true',
                            'aria-label' => __('characters.labels.personality.name'),
                        ]) !!}
                    </div>
                    <div class="dynamic-row-delete btn2 btn-error btn-sm btn-outline" title="{{ __('crud.remove') }}" role="button" tabindex="0">
                        <x-icon class="trash"></x-icon>
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </div>
                </div>
                <div class="field-personality-entry">
                    <label class="sr-only">{{ __('characters.labels.personality.entry') }}</label>
                    {!! Form::textarea('personality_entry[]', null, [
                        'class' => 'form-control',
                        'placeholder' => __('characters.placeholders.personality_entry'),
                        'spellcheck' => 'true',
                        'rows' => 3,
                        'aria-label' => __('characters.labels.personality.entry'),
                    ]) !!}
                </div>
            </div>
        </div>
    </div>

@endsection
