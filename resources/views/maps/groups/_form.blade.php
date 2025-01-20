    <x-grid>
    <x-forms.field
        required
        :label="__('crud.fields.name')"
        field="name"
        css="col-span-2">
        <input type="text" name="name" maxlength="191" placeholder="{{ __('maps/groups.placeholders.name') }}" required value="{!! htmlspecialchars(old('name', $model->name ?? null)) !!}" />
    </x-forms.field>

    <x-forms.field
        field="shown col-span-2"
        :label="__('maps/groups.fields.is_shown')">
        <input type="hidden" name="is_shown" value="0" />
        <x-checkbox :text="__('maps/groups.hints.is_shown')">
            <input type="checkbox" name="is_shown" value="1" @if (old('is_shown', $model->is_shown ?? true)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @php
        $options = $map->groupPositionOptions(!empty($model->position) ? $model->position : null);
        $last = array_key_last($options);
    @endphp
    <x-forms.field
        field="position"
        :label="__('maps/groups.fields.position')">
        <x-forms.select name="position" :options="$options" :selected="$model->position ?? $last" />
    </x-forms.field>

    @include('cruds.fields.visibility_id')
</x-grid>
