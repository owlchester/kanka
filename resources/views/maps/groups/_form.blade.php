    <x-grid>
    <x-forms.field
        :required="true"
        :label="__('crud.fields.name')"
        field="name"
        css="col-span-2">
        <input type="text" name="name" maxlength="191" placeholder="{{ __('maps/groups.placeholders.name') }}" required value="{{ old('name', $model->name ?? null) }}" />
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
        {!! Form::select('position', $options, (!empty($model->position) ? $model->position : $last), ['class' => '']) !!}
    </x-forms.field>

    @include('cruds.fields.visibility_id')
</x-grid>
