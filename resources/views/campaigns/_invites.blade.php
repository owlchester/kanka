<?php
/**
 * @var \App\Models\CampaignUser[] $users
 * @var \App\Models\CampaignRole[] $roles
 * @var \App\Models\CampaignInvite[] $invitations
 */
?>
@if (auth()->user()->can('invite', $campaign))
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('campaigns.members.invite.title') }}
            </h3>
            <div class="box-tools">
                <button class="btn btn-default btn-sm" data-toggle="modal"
                        data-target="#invite-help">
                    <i class="fas fa-question-circle" aria-hidden="true"></i>
                    <span class="hidden-xs hidden-md">{{ __('campaigns.members.actions.help') }}</span>
                </button>

                <a href="{{ route('campaign_invites.create') }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('campaign_invites.create', ['type' => 'link']) }}">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span class="hidden-xs hidden-md">{{ __('campaigns.invites.actions.link') }}</span>
                </a>

                <a href="{{ route('campaign_invites.create', ['type_id' => \App\Models\CampaignInvite::TYPE_EMAIL]) }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('campaign_invites.create', ['type_id' => \App\Models\CampaignInvite::TYPE_EMAIL]) }}">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <span class="hidden-xs hidden-md">{{ __('campaigns.invites.actions.add') }}</span>
                </a>
            </div>
        </div>
        @if($invitations->count() > 0)
            <div class="box-body no-padding">
                <div class="table-responsive">
                    <table id="campaign-invites" class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>{{ __('campaigns.invites.fields.type') }}</th>
                            <th class="hidden-xs hidden-sm">{{ __('campaigns.invites.fields.usage') }}</th>
                            <th>{{ __('campaigns.invites.fields.role') }}</th>
                            <th class="hidden-xs hidden-md">{{ __('campaigns.invites.fields.created') }}</th>
                            <th class="text-right">

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($invitations as $relation)
                            <tr>
                                <td>
                                    @if($relation->isEmail())<span class="hidden-sm hidden-xs">{{ $relation->email }}</span>
                                    @else
                                        <a href="{{ route('campaigns.join', ['token' => $relation->token]) }}">
                                            {{ substr($relation->token, 0, 6) . '...' }}
                                        </a>
                                        <a href="#" title="{{ __('campaigns.invites.actions.copy') }}" data-clipboard="{{ route('campaigns.join', ['token' => $relation->token]) }}" data-toggle="tooltip">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="hidden-xs hidden-sm">
                                    {{ $relation->validity !== null ? $relation->validity : __('campaigns.invites.unlimited_validity') }}
                                </td>
                                <td>{{ $relation->role ? $relation->role->name : null }}</td>
                                <td class="hidden-xs hidden-md">
                                <span title="{{ $relation->created_at }}+00:00" data-toggle="tooltip">
                                    {{ $relation->created_at->diffForHumans() }}
                                </span>
                                </td>

                                <td class="text-right">
                                    {!! Form::open(['method' => 'DELETE','route' => ['campaign_invites.destroy', $relation->id],'style'=>'display:inline']) !!}
                                    <button class="btn btn-xs btn-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i> <span  class="hidden-xs hidden-md">{{ __('crud.remove') }}</span>
                                    </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </thead>
                    </table>
                </div>
            </div>
            @if($invitations->hasPages())
                <div class="box-footer">
                    {{ $invitations->links() }}
                </div>
            @endif
        @else
            <div class="box-body">
                <p class="help-block">
                    {!! __('campaigns.members.invite.description') !!}
                </p>
            </div>
        @endif
    </div>
@endif

<div class="modal fade" id="invite-help" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    {{ __('campaigns.members.invite.title') }}
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    {{ __('campaigns.members.invite.description') }}
                </p>
                <p>
                    {!! __('campaigns.members.invite.more', [
                        'link' =>
                            '<a href="' . route('campaign_roles.index') . '">'
                            . __('campaigns.members.invite.roles_page') . '</a>'
                    ]) !!}
                </p>
            </div>
        </div>
    </div>
</div>
