<x-grid>
    <x-grid type="1/1">
        <x-forms.field
            field="appearance"
            :label="__('characters.sections.appearance')">
            <div class="flex flex-col gap-2 character-appearance sortable-elements" data-handle=".sortable-handler">
                @foreach ((isset($model) ? $model->characterTraits()->appearance()->orderBy('default_order', 'ASC')->get() : FormCopy::characterAppearance()) as $trait)
                    <x-grid class="parent-delete-row">
                        <div class="flex gap-1 items-center">
                            <div class="sortable-handler px-2 cursor-move">
                                <x-icon class="fa-regular fa-grip-vertical" />
                            </div>
                            <div class="grow field">
                                <label class="sr-only">{{ __('characters.labels.appearance.name') }}</label>
                                <input type="text" name="appearance_name[{{ $trait->id }}]" value="{{ $trait->name }}" class="w-full" placeholder="{{ __('characters.placeholders.appearance_name') }}" spellcheck="true" aria-label="{{ __('characters.labels.appearance.name') }}" maxlength="191" />
                            </div>
                        </div>
                        <div class="flex gap-1 items-center">
                            <div class="grow field">
                                <label class="sr-only">{{ __('characters.labels.appearance.entry') }}</label>
                                <input type="text" name="appearance_entry[{{ $trait->id }}]" value="{{ $trait->entry }}" class="w-full" placeholder="{{ __('characters.placeholders.appearance_entry') }}" spellcheck="true" aria-label="{{ __('characters.labels.appearance.entry') }}"  maxlength="191" />
                            </div>
                            <div class="dynamic-row-delete cursor-pointer hover:text-error text-base-content text-lg" title="{{ __('crud.remove') }}" role="button" tabindex="0">
                                <x-icon class="trash" />
                                <span class="sr-only">{{ __('crud.remove') }}</span>
                            </div>
                        </div>
                    </x-grid>
                @endforeach
            </div>
            <button class="btn2 btn-sm btn-outline btn-block dynamic-row-add" data-template="template_appearance" data-target="character-appearance">
                <x-icon class="plus" />
                {{ __('characters.actions.add_appearance') }}
            </button>
        </x-forms.field>

        <x-forms.field
            field="appearance-pinned"
            :label="__('characters.fields.is_appearance_pinned')">
            <input type="hidden" name="is_appearance_pinned" value="0" />

            <x-checkbox :text="__('characters.hints.is_appearance_pinned')">
                <input type="checkbox" name="is_appearance_pinned" value="1" @if (old('is_appearance_pinned', $source->child->is_appearance_pinned ?? $model->is_appearance_pinned ?? false)) checked="checked" @endif/>
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
                                <x-icon class="fa-regular fa-grip-vertical" />
                            </div>
                            <div class="grow field">
                                <label class="sr-only">{{ __('characters.labels.personality.name') }}</label>
                                <input type="text" name="personality_name[{{ $trait->id }}]" value="{{ $trait->name }}" class="w-full" placeholder="{{ __('characters.placeholders.personality_name') }}" spellcheck="true" aria-label="{{ __('characters.labels.personality.name') }}" maxlength="191" />
                            </div>
                            <div class="dynamic-row-delete cursor-pointer hover:text-error text-base-content text-lg" role="button" tabindex="0" >
                                <x-icon class="trash" />
                                <span class="sr-only">{{ __('crud.remove') }}</span>
                            </div>
                        </div>
                        <div class="field-personality-entry">
                            <label class="sr-only field">{{ __('characters.labels.personality.entry') }}</label>
                            <textarea name="personality_entry[{{ $trait->id }}]" placeholder="{{ __('characters.placeholders.personality_entry') }}" class="w-full" rows="3" spellcheck="true" aria-label="{{ __('characters.labels.personality.entry') }}">{!! old('personality_entry[' . $trait->id . ']', $trait->entry) !!}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="btn2 btn-sm btn-outline btn-block dynamic-row-add" data-template="template_personality" data-target="character-personality">
                <x-icon class="plus" />
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
                <input type="checkbox" name="is_personality_pinned" value="1" @if (old('is_personality_pinned', $source->child->is_personality_pinned ?? $model->is_personality_pinned ?? false)) checked="checked" @endif/>
            </x-checkbox>
        </x-forms.field>
    @endif

    @can('admin', $campaign)
        @php $helper = __('characters.helpers.personality_visible', [
            'admin' => '<a href=\'' . route('campaigns.campaign_roles.admin', $campaign) . '\' class=\'text-link\'>' . $campaign->adminRoleName() . '</a>']); @endphp
        <hr>
        <input type="hidden" name="is_personality_visible" value="0" />
        <x-forms.field
            field="personality-visible"
            :label="__('characters.fields.is_personality_visible')"
            :helper="$helper"
        >
            <x-checkbox :text="__('characters.hints.is_personality_visible', [
    'admin' => '<a href=\'' . route('campaigns.campaign_roles.admin', $campaign) . '\' class=\'text-link\'>' . $campaign->adminRoleName() . '</a>'
])">
                <input type="checkbox" name="is_personality_visible" value="1" @if (old('is_personality_visible', $source->child->is_personality_visible ?? $model->is_personality_visible ?? false)) checked="checked" @endif/>
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
        <x-grid class="parent-delete-row gap-1">
            <div class="flex gap-1 items-center">
                @if(!isset($model))
                    <div class="sortable-handler px-2 cursor-move">
                        <x-icon class="fa-regular fa-grip-vertical" />
                    </div>
                @endif
                <div class="grow field">
                    <label class="sr-only">{{ __('characters.labels.appearance.name') }}</label>
                    <input type="text" name="appearance_name[]" class="w-full" placeholder="{{ __('characters.placeholders.appearance_name') }}" spellcheck="true" aria-label="{{ __('characters.labels.appearance_name') }}" maxlength="191" />
                </div>
            </div>
            <div class="flex gap-1 items-center">
                <div class="grow field">
                    <label class="sr-only">{{ __('characters.labels.appearance.entry') }}</label>
                    <input type="text" name="appearance_entry[]" class="w-full" placeholder="{{ __('characters.placeholders.appearance_entry') }}" spellcheck="true" aria-label="{{ __('characters.labels.appearance.entry') }}" maxlength="191" />
                </div>
                <div class="dynamic-row-delete cursor-pointer hover:text-error text-base-content text-lg" role="button" tabindex="0">
                    <x-icon class="trash" />
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
                    <x-icon class="fa-regular fa-grip-vertical" />
                </div>
                @endif
                <div class="grow field">
                    <label class="sr-only">{{ __('characters.labels.personality.name') }}</label>
                    <input type="text" name="personality_name[]" class="w-full" placeholder="{{ __('characters.placeholders.personality_name') }}" spellcheck="true" aria-label="{{ __('characters.labels.personality.name') }}" maxlength="191" />
                </div>
                <div class="dynamic-row-delete cursor-pointer hover:text-error text-base-content text-lg" title="{{ __('crud.remove') }}" role="button" tabindex="0">
                    <x-icon class="trash" />
                    <span class="sr-only">{{ __('crud.remove') }}</span>
                </div>
            </div>
            <div class="field-personality-entry field">
                <label class="sr-only">{{ __('characters.labels.personality.entry') }}</label>

                <textarea name="personality_entry[]" placeholder="{{ __('characters.placeholders.personality_entry') }}" class="w-full" rows="3" spellcheck="true" aria-label="{{ __('characters.labels.personality.entry') }}"></textarea>
            </div>
        </div>
    </template>

@endsection

