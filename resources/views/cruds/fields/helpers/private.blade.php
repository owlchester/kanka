@php
    $role = \App\Facades\CampaignCache::adminRole();
@endphp
<x-helper>
    {!! __('crud.fields.is_private_v3', [
'admin-role' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')), $campaign, ['target' => '_blank'])
]) !!}
</x-helper>
