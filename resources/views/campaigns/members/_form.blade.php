@php
$helper = __('campaigns/members.roles.admin', ['admin' => '<a href="' . route('campaigns.campaign_roles.admin', $campaign) . '" class="text-link">' . CampaignCache::campaign($campaign)->adminRole()['name'] . '</a>']);
@endphp
<x-grid type="1/1">
    <x-helper>
        <p>{!! __('campaigns/members.roles.helper', ['user' => '<a href="' . route('users.profile', $campaignUser->user) . '" class="text-link">' . $campaignUser->user->name . '</a>']) !!}</p>
    </x-helper>
    <input type="hidden" name="save_roles" value="1">
    <x-forms.field field="roles" :label="__('campaigns.members.fields.roles')" :helper="$helper">
        @include('components.form.role', ['options' => [
            'multiple' => true,
            'model' => $campaignUser,
            'roles' => $roles ?? false
        ]])
    </x-forms.field>
</x-grid>
