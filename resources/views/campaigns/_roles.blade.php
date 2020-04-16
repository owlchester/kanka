<?php /** @var \App\Models\CampaignRole $relation */?>
<div class="box-header with-border">
    <h2 class="box-title">
        {{ __('campaigns.show.tabs.roles') }}
    </h2>
</div>
<div class="box-body">

    <p class="help-block">{{ __('campaigns.roles.helper.1') }}</p>
    <p class="help-block">{{ __('campaigns.roles.helper.2') }}</p>
    <p class="help-block">{{ __('campaigns.roles.helper.3') }}</p>

    <table id="campaign-roles" class="table table-hover table-striped">
        <tbody><tr>
            <th>{{ __('campaigns.roles.fields.name') }}</th>
            <th>
                <span class="hidden-xs">{{ __('campaigns.roles.fields.users') }}</span>
                <i class="fa fa-users visible-xs"></i>
            </th>
            <th class="hidden-xs">{{ __('campaigns.roles.fields.type') }}</th>
            <th class="hidden-xs">{{ __('campaigns.roles.fields.permissions') }}</th>
            <th></th>
            <th>
            </th>
        </tr>
        @foreach ($r = $campaign->roles()
                ->with(['users', 'permissions', 'campaign'])
                ->orderBy('is_admin', 'DESC')
                ->orderBy('is_public', 'DESC')
                ->orderBy('name')
                ->paginate() as $relation)
            <tr>
                <td>
                    <a href="{{ route('campaign_roles.show', ['campaign_role' => $relation]) }}">{{ $relation->name }}</a></td>
                <td>{{ $relation->users->count() }}
                </td>
                <td class="hidden-xs">
                    {{ __('campaigns.roles.types.' . ($relation->is_admin ? 'owner' : ($relation->is_public ? 'public' : 'standard'))) }}
                </td>
                <td class="hidden-xs">
                    @if (!$relation->is_admin)
                        {{ $relation->permissions->count() }}
                    @endif</td>
                <td>
                    @if($relation->is_public && !$campaign->is_public)
                        <div class="hidden-xs">
                            <i class="fa fa-exclamation-triangle" data-toggle="tooltip" title="{{ __('campaigns.roles.hints.campaign_not_public') }}"></i>
                        </div>
                        <div class="visible-xs">
                             <i class="fa fa-exclamation-triangle" data-toggle="collapse" data-target="#campaign-public-warning"></i>
                            <span class="collapse help-block" id="campaign-public-warning">{{ __('campaigns.roles.hints.campaign_not_public') }}</span>
                        </div>
                    @endif
                </td>

                <td class="text-right">
                    <a href="{{ route('campaign_roles.show', ['campaign_role' => $relation]) }}" class="btn btn-xs btn-default" title="{{ __('crud.manage') }}">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </a>
                    @can('update', $relation)
                        <a href="{{ route('campaign_roles.edit', ['campaign_role' => $relation]) }}" class="btn btn-xs btn-primary"
                           title="{{ __('crud.edit') }}"
                           data-toggle="ajax-modal" data-target="#entity-modal"
                           data-url="{{ route('campaign_roles.edit', ['campaign_role' => $relation]) }}"
                        >
                            <i class="fa fa-edit" aria-hidden="true"></i>
                        </a>
                    @endcan
                    @can('delete', $relation)
                        <button class="btn btn-xs btn-danger delete-confirm" title="{{ __('crud.remove') }}"
                                data-toggle="modal" data-name="{{ $relation->name }}"
                                data-target="#delete-confirm" data-delete-target="campaign-role-{{ $relation->id }}"
                        >
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['campaign_roles.destroy', 'campaign_role' => $relation],
                            'style' => 'display:inline',
                            'id' => 'campaign-role-' . $relation->id,
                        ]) !!}

                        {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $r->fragment('tab_roles')->links() }}
</div>

<div class="box-footer">

@if (Auth::user()->can('update', $campaign))
    <a href="{{ route('campaign_roles.create') }}" class="btn btn-primary btn-block"
       data-toggle="ajax-modal" data-target="#entity-modal"
       data-url="{{ route('campaign_roles.create') }}"
    >
        <i class="fa fa-plus" aria-hidden="true"></i>
        {{ __('campaigns.roles.actions.add') }}
    </a>
@endif
</div>

