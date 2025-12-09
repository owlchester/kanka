<x-helper>
    <p>{!! __('crud.fields.is_private_v3', [
    'admin-role' => '<a href="' . route(
        'campaigns.campaign_roles.admin',
        $campaign,
    ) . '" class="text-link">' .
    $campaign->adminRoleName() . '</a>',

]) !!}</p>
</x-helper>
