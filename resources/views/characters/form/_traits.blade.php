<?php
$role = \App\Facades\CampaignCache::adminRole();
?>
<x-grid>
    <x-grid type="1/1">
        <x-forms.field
            field="appearance"
            :label="__('characters.sections.appearance')">
            <div class="flex flex-col gap-2 character-appearance sortable-elements" data-handle=".sortable-handler">
                @foreach ((isset($model) ? $model->characterTraits()->appearance()->orderBy('default_order', 'ASC')->get() : FormCopy::characterAppearance()) as $trait)
                    <x-grid css="parent-delete-row">
                        <div class="flex gap-1 items-center">
                            <div class="sortable-handler px-2 cursor-move">
                                <x-icon class="fa-solid fa-grip-vertical" />
                            </div>
                            <div class="grow field">
                                <label class="sr-only">{{ __('characters.labels.appearance.name') }}</label>
                                {!! Form::text('appearance_name[' . $trait->id . ']', $trait->name, [
                                    'class' => 'w-full',
                                    'maxlength' => 191,
                                    'placeholder' => __('characters.placeholders.appearance_name'),
                                    'spellcheck' => 'true',
                                    'aria-label' => __('characters.labels.appearance.name'),
                                ]) !!}
                            </div>
                        </div>
                        <div class="flex gap-1 items-center">
                            <div class="grow field">
                                <label class="sr-only">{{ __('characters.labels.appearance.entry') }}</label>
                                {!! Form::text('appearance_entry[' . $trait->id . ']', $trait->entry, [
                                    'class' => 'w-full',
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
        </x-forms.field>

        <x-forms.field
            field="appearance-pinned"
            :label="__('characters.fields.is_appearance_pinned')">
            <input type="hidden" name="is_appearance_pinned" value="0" />

            <x-checkbox :text="__('characters.hints.is_appearance_pinned')">
                {!! Form::checkbox('is_appearance_pinned', 1, (!empty($model) ? $model->is_appearance_pinned : (!empty($source) ? FormCopy::field('is_appearance_pinned')->boolean() : null))) !!}
            </x-checkbox>
        </x-forms.field>
    </x-grid>

    <x-grid type="1/1">
        <x-forms.field
            field="personality"
            :label="__('characters.sections.personality')">
            @if (!isset($model) || auth()->user()->can('personality', $model))
            <div class="flex flex-col gap-2 character-personality sortable-elements" data-handle=".sortable-handler">
                @foreach ((isset($model) ? $model->characterTraits()->personality()->orderBy('default_order', 'ASC')->get() : FormCopy::characterPersonality()) as $trait)
                    <div class="grid grid-cols-1 gap-2 parent-delete-row">
                        <div class="flex gap-1 items-center">
                            <div class="sortable-handler px-2 cursor-move">
                                <x-icon class="fa-solid fa-grip-vertical" />
                            </div>
                            <div class="grow field">
                                <label class="sr-only">{{ __('characters.labels.personality.name') }}</label>
                                {!! Form::text('personality_name[' . $trait->id . ']', $trait->name, [
                                    'class' => 'w-full',
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
                            <label class="sr-only field">{{ __('characters.labels.personality.entry') }}</label>
                            {!! Form::textarea('personality_entry[' . $trait->id . ']', $trait->entry, [
                                'class' => 'w-full',
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
            @else
                <x-alert type="warning">
                    {{ __('characters.warnings.personality_hidden') }}
                </x-alert>
            @endif
        </x-forms.field>


        @if (!isset($model) || auth()->user()->can('personality', $model))
            <x-forms.field
                field="personality-pinned"
                :label="__('characters.fields.is_personality_pinned')"
            >
                <input type="hidden" name="is_personality_pinned" value="0" />
                <x-checkbox :text="__('characters.hints.is_personality_pinned')">
                    {!! Form::checkbox('is_personality_pinned', 1, (!empty($model) ? $model->is_personality_pinned : (!empty($source) ? FormCopy::field('is_personality_pinned')->boolean() : null))) !!}
                </x-checkbox>
            </x-forms.field>
        @endif

        @if (\App\Facades\UserCache::user(auth()->user())->admin())
                <hr>
            <input type="hidden" name="is_personality_visible" value="0" />
            <x-forms.field
                field="personality-visible"
                :label="__('characters.fields.is_personality_visible')"
            >
                <x-checkbox :text="__('characters.hints.is_personality_visible', [
        'admin' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')), $campaign, ['target' => '_blank'])
])">
                    {!! Form::checkbox('is_personality_visible', 1, (!empty($model) ? $model->is_personality_visible : (!empty($source) ? FormCopy::field('is_personality_visible')->boolean() : !$campaign->entity_personality_visibility))) !!}
                </x-checkbox>
            </x-forms.field>
        @else
            <input type="hidden" name="is_personality_visible" value="1" />
        @endif
    </x-grid>
</x-grid>


@section('modals')
    @parent
    <template id="template_appearance">
        <x-grid css="parent-delete-row gap-1">
            <div class="flex gap-1 items-center">
                @if(!isset($model))
                    <div class="sortable-handler px-2 cursor-move">
                        <x-icon class="fa-solid fa-grip-vertical" />
                    </div>
                @endif
                <div class="grow field">
                    <label class="sr-only">{{ __('characters.labels.appearance.name') }}</label>
                    {!! Form::text('appearance_name[]', null, [
                        'class' => 'w-full',
                        'placeholder' => __('characters.placeholders.appearance_name'),
                        'spellcheck' => 'true',
                        'aria-label' => __('characters.labels.appearance.name'),
                    ]) !!}
                </div>
            </div>
            <div class="flex gap-1 items-center">
                <div class="grow field">
                    <label class="sr-only">{{ __('characters.labels.appearance.entry') }}</label>
                    {!! Form::text('appearance_entry[]', null, [
                        'class' => 'w-full',
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
    </template>
    <template id="template_personality">
        <div class="grid grid-cols-1 gap-2 parent-delete-row">
            <div class="flex gap-1 items-center">
                @if(!isset($model))
                <div class="sortable-handler px-2 cursor-move">
                    <x-icon class="fa-solid fa-grip-vertical" />
                </div>
                @endif
                <div class="grow field">
                    <label class="sr-only">{{ __('characters.labels.personality.name') }}</label>
                    {!! Form::text('personality_name[]', null, [
                        'class' => 'w-full',
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
            <div class="field-personality-entry field">
                <label class="sr-only">{{ __('characters.labels.personality.entry') }}</label>
                {!! Form::textarea('personality_entry[]', null, [
                    'class' => 'w-full',
                    'placeholder' => __('characters.placeholders.personality_entry'),
                    'spellcheck' => 'true',
                    'rows' => 3,
                    'aria-label' => __('characters.labels.personality.entry'),
                ]) !!}
            </div>
        </div>
    </template>

@endsection
