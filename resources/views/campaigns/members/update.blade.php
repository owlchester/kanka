<x-form :action="['campaign_users.update-roles', $campaign, $campaignUser]">
    @include('partials.forms.form', [
        'title' => __('campaigns/members.roles.title'),
        'content' => 'campaigns.members._form',
        'dialog' => true,
    ])
</x-form>
