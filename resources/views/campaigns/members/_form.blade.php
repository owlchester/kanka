{{ csrf_field() }}
<x-grid type="1/1">
@foreach($roles as $role)
        {!! Form::open(['method' => 'post', 'route' => ['campaign_users.update-roles', [$campaign, $campaignUser, $role]], 'class' => 'w-full']) !!}
            <button class='btn2 btn-block btn-feedback @if($campaignUser->user->hasCampaignRole($role->id)) btn-error btn-outline @endif'>
                @if($campaignUser->user->hasCampaignRole($role->id))
                    <x-icon class="trash" />
                    {{ $role->name }}
                @else
                    <x-icon class="plus" />
                    {{ $role->name }}
                @endif
            </button>
        {!! Form::close() !!}
    @endforeach
</x-grid>

