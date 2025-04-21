<x-grid type="1/1">
    @empty($model)
        <x-helper>{{ __('campaigns/roles.create.helper') }}</x-helper>
    @endif
<x-forms.field
    field="name"
    required
    :label="__('campaigns.roles.fields.name')"
    >
    <input type="text" name="name" placeholder="{{ __('campaigns.roles.placeholders.name') }}" maxlength="45" required value="{!! htmlspecialchars(old('name', $model->name ?? null)) !!}" />
</x-forms.field>
@if (isset($roleId))
    <x-forms.field
        field="duplicate"
        :label="__('campaigns.roles.fields.copy_permissions')">
        <input type="hidden" name="role_id" value="{{ $roleId }}" />
        <input type="hidden" name="duplicate" value="0" />
        <x-checkbox :text="__('campaigns.roles.helper.permissions_helper')">
            <input type="checkbox" name="duplicate" value="1" @if (old('duplicate', true)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>
@endif
</x-grid>

