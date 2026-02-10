<x-forms.field
    field="field-two-way">
    <label
        for="two_way"
        class="text-xs font-medium opacity-80">
        {{ __('entities/relations.fields.link') }}
    </label>
    <label class="!flex gap-2">
                <span>
                    <input
                        type="checkbox"
                        name="two_way"
                        id="two_way"
                        value="1" @if (old('two_way', false)) checked="checked" @endif
                        @click="opened = !opened" />
                </span>
        <div class="text-neutral-content">
            {{ __('entities/relations.helpers.link') }}
        </div>
    </label>
</x-forms.field>

<div>
    <div x-show="opened">
        <x-forms.field
            field="target-relation"
            :label="__('entities/relations.fields.mirror_relation')"
            :helper="__('entities/relations.helpers.mirror_relation')">
            <input type="text" name="target_relation" value="{{ old('target_relation', $relation->target_relation ?? null) }}" maxlength="191" class="w-full" aria-label="{{ __('entities/relations.placeholders.role') }}" placeholder="{{ __('entities/relations.placeholders.role') }}" />
        </x-forms.field>
    </div>
</div>
