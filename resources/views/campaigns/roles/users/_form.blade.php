{{ csrf_field() }}
<x-grid type="1/1">
<x-forms.field field="user" :required="true" :label="__('campaigns.members.fields.name')">
    {!! Form::select('user_id', $campaign->membersList($role->users->pluck('user_id')->toArray()), null, ['class' => 'w-full']) !!}
</x-forms.field>

@if($role->isAdmin())
    <x-alert type="warning">
        <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
        {!! __('campaigns/roles.warnings.adding-to-admin', ['name' => $role->name, 'amount' => '<strong>15</strong>']) !!}
    </x-alert>
@endif
</x-grid>

