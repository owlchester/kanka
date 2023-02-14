@php
    $role = \App\Facades\CampaignCache::adminRole();
@endphp
<p class="help-block">
    {!! __('crud.fields.is_private_v3', [
'admin-role' => link_to_route('campaign_roles.admin', \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')), CampaignLocalization::getCampaign(), ['target' => '_blank'])
]) !!}
</p>
