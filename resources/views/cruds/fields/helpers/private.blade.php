@php
    $role = \App\Facades\CampaignCache::adminRole();
@endphp
<p class="help-block">
    {!! __('crud.fields.is_private_v3', [
'admin-role' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')), null, ['target' => '_blank'])
]) !!}
</p>
