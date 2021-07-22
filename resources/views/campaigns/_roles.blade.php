<?php /** @var \App\Models\CampaignRole $relation */ ?>
<div class="box-header with-border">
    <h3 class="box-title">
        <i class="fa fa-users-cog"></i> {{ __('campaigns.show.tabs.roles') }}
    </h3>
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

                    <a href="{{ route('campaign_roles.show', ['campaign_role' => $relation]) }}" title="{{ __('campaigns.roles.actions.permissions') }}">
                        {{ $relation->permissions->whereNull('entity_id')->count() }}
                    </a>

                    @endif</td>
                <td>
                    @if($relation->is_public && !$campaign->is_public && $relation->permissions->whereNull('entity_id')->count() > 0)
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
                    <div class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" data-placement="right">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li>
                                <a href="{{ route('campaign_roles.show', ['campaign_role' => $relation]) }}" title="{{ __('crud.manage') }}">
                                    <i class="fa fa-users" aria-hidden="true"></i> {{ __('campaigns.roles.actions.permissions') }}
                                </a>
                            </li>
                            @can('update', $relation)
                                <li>
                                    <a href="{{ route('campaign_roles.edit', ['campaign_role' => $relation]) }}"
                                       title="{{ __('crud.edit') }}"
                                       data-toggle="ajax-modal" data-target="#entity-modal"
                                       data-url="{{ route('campaign_roles.edit', ['campaign_role' => $relation]) }}"
                                    >
                                        <i class="fa fa-edit" aria-hidden="true"></i> {{ __('campaigns.roles.actions.rename') }}
                                    </a>
                                </li>
                            @endcan

                            @can('delete', $relation)
                                <li class="divider"></li>
                                <li>
                                    <a href="#" class="text-red delete-confirm" title="{{ __('crud.remove') }}"
                                            data-toggle="modal" data-name="{{ $relation->name }}"
                                            data-target="#delete-confirm" data-delete-target="campaign-role-{{ $relation->id }}"
                                    >
                                        <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </div>





                    @can('delete', $relation)
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

