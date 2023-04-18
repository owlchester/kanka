{{ csrf_field() }}
<div class="form-group required">
    <label>{{ __('campaigns.members.fields.name') }}</label>
    {!! Form::select('user_id', $campaign->membersList($role->users->pluck('user_id')->toArray()), null, ['class' => 'form-control']) !!}
</div>

@if($role->isAdmin())
    <div class="alert alert-warning">
        <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
        {!! __('campaigns/roles.warnings.adding-to-admin', ['name' => $role->name, 'amount' => '<strong>15</strong>']) !!}
    </div>
@endif

