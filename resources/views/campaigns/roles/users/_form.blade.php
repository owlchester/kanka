<x-grid type="1/1">
<x-forms.field field="user" required :label="__('campaigns.members.fields.name')">

    <x-forms.select name="user_id" :options="$campaign->membersList($role->users->pluck('user_id')->toArray())" class="w-full select2" />
</x-forms.field>

@if($role->isAdmin())
    <x-alert type="warning">
        <x-icon class="fa-solid fa-exclamation-triangle" />
        <p>
            {!! __('campaigns/roles.warnings.adding-to-admin', ['name' => $role->name, 'amount' => '<strong>15</strong>']) !!}
        </p>
    </x-alert>
@endif
</x-grid>

