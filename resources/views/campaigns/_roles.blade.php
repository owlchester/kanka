<?php /**
 * @var \App\Models\CampaignRole[] $roles
 * @var \App\Models\Campaign $campaign
 */
?>

<div class="mb-2">
    <div class="pull-right">
        <button class="btn btn-default btn-sm" data-toggle="dialog"
                data-target="roles-help">
            <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
            {{ __('campaigns.members.actions.help') }}
        </button>
        @if (auth()->user()->can('update', $campaign))
            <a href="{{ route('campaign_roles.create') }}" class="btn btn-primary btn-sm"
               data-toggle="ajax-modal" data-target="#entity-modal"
               data-url="{{ route('campaign_roles.create') }}"
            >
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                {{ __('campaigns.roles.actions.add') }}
            </a>
        @endif
    </div>
    <h3 class="mt-0 inline-block">
        {{ __('campaigns.show.tabs.roles') }} <small>({{ $roles->total() }} / @if ($limit = $campaign->roleLimit()){{ $limit }}@else<i class="fa-solid fa-infinity"></i>@endif)</small>
    </h3>
</div>

<div class="box box-solid">
    <div class="box-body no-padding">
        <table id="campaign-roles" class="table table-hover table-striped">
            <thead><tr>
                <th>{{ __('campaigns.roles.fields.name') }}</th>
                <th>
                    <span class="hidden-xs">{{ __('campaigns.roles.fields.users') }}</span>
                    <i class="fa-solid fa-users visible-xs"></i>
                </th>
                <th class="hidden-xs">{{ __('campaigns.roles.fields.type') }}</th>
                <th class="hidden-xs">{{ __('campaigns.roles.fields.permissions') }}</th>
                <th></th>
                <th>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $relation)
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
                                <i class="fa-solid fa-exclamation-triangle" data-toggle="tooltip" title="{{ __('campaigns.roles.hints.campaign_not_public') }}"></i>
                            </div>
                            <div class="visible-xs">
                                 <i class="fa-solid fa-exclamation-triangle" data-toggle="collapse" data-target="#campaign-public-warning"></i>
                                <span class="collapse help-block" id="campaign-public-warning">{{ __('campaigns.roles.hints.campaign_not_public') }}</span>
                            </div>
                        @endif
                    </td>

                    <td class="text-right">
                        <div class="dropdown">
                            <a class="dropdown-toggle btn btn-sm btn-default" data-toggle="dropdown" aria-expanded="false" data-placement="right">
                                <i class="fa-solid fa-ellipsis-h"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li>
                                    <a href="{{ route('campaign_roles.show', ['campaign_role' => $relation]) }}" title="{{ __('crud.manage') }}">
                                        <i class="fa-solid fa-users" aria-hidden="true"></i> {{ __('campaigns.roles.actions.permissions') }}
                                    </a>
                                </li>
                                @can('update', $relation)
                                    <li>
                                        <a href="{{ route('campaign_roles.edit', ['campaign_role' => $relation]) }}"
                                           title="{{ __('crud.edit') }}"
                                           data-toggle="ajax-modal" data-target="#entity-modal"
                                           data-url="{{ route('campaign_roles.edit', ['campaign_role' => $relation]) }}"
                                        >
                                            <i class="fa-solid fa-edit" aria-hidden="true"></i> {{ __('campaigns.roles.actions.rename') }}
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
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
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
    </div>
@if($roles->hasPages())
    <div class="box-footer text-right">
        {!! $roles->fragment('tab_roles')->links() !!}
    </div>
@endif
</div>

@php
    $role = \App\Facades\CampaignCache::adminRole();
@endphp

@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'roles-help',
        'title' => __('campaigns.show.tabs.roles'),
        'textes' => [
            __('campaigns.roles.helper.1', [
                'admin' => link_to_route(
                    'campaigns.campaign_roles.admin',
                    \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')),
                    null,
                    ['target' => '_blank']
                )
            ]),
            __('campaigns.roles.helper.2'),
            __('campaigns.roles.helper.3'),
            __('campaigns.roles.helper.4'),
        ]
    ])
@endsection
