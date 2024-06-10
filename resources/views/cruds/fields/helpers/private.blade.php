@php
    $role = \App\Facades\CampaignCache::adminRole();
@endphp
<x-helper>
    {!! __('crud.fields.is_private_v3', [
    'admin-role' => '<a href="' . route(
        'campaigns.campaign_roles.admin',
        $campaign,
    ) . '" target="_blank">' .
    \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')) . '</a>',

]) !!}
</x-helper>
