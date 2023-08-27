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
        {!! Form::hidden('role_id', $roleId) !!}
        {!! Form::hidden('duplicate', 0) !!}
        <label class="font-normal">
            {!! Form::checkbox('duplicate', 1, null, ['id' => 'duplicate']) !!}
            {{ __('campaigns.roles.helper.permissions_helper') }}
        </label>
    </x-forms.field>
@endif
</x-grid>

