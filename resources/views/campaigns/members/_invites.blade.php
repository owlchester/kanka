<?php
/**
 * @var \App\Models\CampaignUser[] $users
 * @var \App\Models\CampaignRole[] $roles
 * @var \App\Models\CampaignInvite[] $invitations
 */
?>
@can('invite', $campaign)

    <div class="flex gap-2 items-center">
        <h3 class="inline-block grow">
            {{ __('campaigns.members.invite.title') }}
        </h3>
        <button class="btn2 btn-sm btn-ghost" data-toggle="dialog" data-target="invite-help">
            <x-icon class="question" />
            {{ __('general.learn-more') }}
        </button>

        <a href="{{ route('campaign_invites.create', $campaign) }}" class="btn2 btn-primary btn-sm"
            data-toggle="dialog-ajax" data-target="primary-dialog" data-url="{{ route('campaign_invites.create', $campaign) }}">
            <x-icon class="fa-solid fa-user-plus" />
            <span class="hidden lg:inline">{{ __('campaigns.invites.actions.link') }}</span>
        </a>
    </div>

    @if($invitations->count() > 0)
            <div class="table-responsive">
                <table id="campaign-invites" class="table table-hover rounded-xl bg-base-100">
                    <thead>
                        <tr>
                            <th>{{ __('campaigns.invites.fields.token') }}</th>
                            <th class="hidden md:table-cell">{{ __('campaigns.invites.fields.usage') }}</th>
                            <th>{{ __('campaigns.invites.fields.role') }}</th>
                            <th class="hidden md:table-cell">{{ __('campaigns.invites.fields.created') }}</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($invitations as $relation)
                        <tr>
                            <td>
                                <a href="{{ route('campaigns.join', [$campaign, 'token' => $relation->token]) }}">
                                    {{ substr($relation->token, 0, 6) . '...' }}
                                </a>
                                <a href="#" data-title="{{ __('campaigns.invites.actions.copy') }}" data-clipboard="{{ route('campaigns.join', ['token' => $relation->token]) }}" data-toggle="tooltip" data-toast="{{ __('crud.alerts.copy_invite') }}">
                                    <x-icon class="fa-solid fa-copy" />
                                    <span class="sr-only">{{ __('Copy') }}</span>
                                </a>
                            </td>
                            <td class="hidden md:table-cell">
                                {{ $relation->validity !== null ? $relation->validity : __('campaigns.invites.unlimited_validity') }}
                            </td>
                            <td>{{ $relation->role ? $relation->role->name : null }}</td>
                            <td class="hidden md:table-cell">
                                <span data-title="{{ $relation->created_at }}+00:00" data-toggle="tooltip">
                                    {{ $relation->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="text-right">
                                <x-buttons.confirm-delete :route="route('campaign_invites.destroy', [$campaign, $relation->id])" />
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if($invitations->hasPages())
                <div class="text-right">
                    {{ $invitations->links() }}
                </div>
            @endif
        @else
        <x-box>
            <x-helper>
                <p>{!! __('campaigns.members.invite.description', ['campaign' => $campaign->link()]) !!}</p>
            </x-helper>
        </x-box>
        @endif
@endif


@section('modals')
    <x-dialog id="new-invite" :loading="true" />
    @parent
    @include('partials.helper-modal', [
        'id' => 'invite-help',
        'title' => __('campaigns.members.invite.title'),
        'textes' => [
            __('campaigns.members.invite.description', ['campaign' => $campaign->link()]),
            __('campaigns.members.invite.more', [
                        'link' =>
                            '<a href="' . route('campaign_roles.index', $campaign) . '">'
                            . __('campaigns.show.tabs.roles') . '</a>'
                    ])
        ]
    ])

    <div class="modal fade" id="small-modal" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content rounded-2xl bg-base-100" id="small-modal-content"></div>
        </div>
    </div>
@endsection
