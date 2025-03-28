<x-form :action="['campaign_users.update-roles', $campaign, $campaignUser]">
    @include('partials.forms._dialog', [
        'title' => __('campaigns/members.roles.title'),
        'content' => 'campaigns.members._form',
    ])
</x-form>
