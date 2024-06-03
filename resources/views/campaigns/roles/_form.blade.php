{{ csrf_field() }}
<x-grid type="1/1">
<x-forms.field
    field="name"
    :required="true"
    :label="__('campaigns.roles.fields.name')"
    >
    {!! Form::text('name', null, ['placeholder' => trans('campaigns.roles.placeholders.name'), 'class' => '', 'maxlength' => 45, 'required']) !!}
</x-forms.field>
@if (isset($roleId))
    <x-forms.field
        field="duplicate"
        :label="__('campaigns.roles.fields.copy_permissions')">
        <input type="hidden" name="role_id" value="{{ $roleId }}" />
        <input type="hidden" name="duplicate" value="0" />
        <x-checkbox :text="__('campaigns.roles.helper.permissions_helper')">
            {!! Form::checkbox('duplicate', 1, null, ['id' => 'duplicate']) !!}
        </x-checkbox>
    </x-forms.field>
@endif
</x-grid>

