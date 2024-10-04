<x-grid type="1/1">
    @foreach($roles as $role)
        <x-form :action="['campaign_users.update-roles', $campaign, $campaignUser, $role]">
            <button class='btn2 btn-block btn-feedback @if($campaignUser->user->hasCampaignRole($role->id)) btn-error btn-outline @endif'>
                @if($campaignUser->user->hasCampaignRole($role->id))
                    <x-icon class="trash" />
                    {!! $role->name !!}
                @else
                    <x-icon class="plus" />
                    {!! $role->name !!}
                @endif
            </button>
        </x-form>
    @endforeach
</x-grid>
