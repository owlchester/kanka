
<div class="box-header with-border">
    <h2 class="box-title">
        {{ trans('campaigns.show.tabs.roles') }}
    </h2>
</div>
<div class="box-body">

    <p class="help-block">{{ trans('campaigns.roles.helper.1') }}</p>
    <p class="help-block">{{ trans('campaigns.roles.helper.2') }}</p>
    <p class="help-block">{{ trans('campaigns.roles.helper.3') }}</p>

    <table id="campaign-roles" class="table table-hover table-striped">
        <tbody><tr>
            <th>{{ trans('campaigns.roles.fields.name') }}</th>
            <th>
                <span class="hidden-xs">{{ trans('campaigns.roles.fields.users') }}</span>
                <i class="fa fa-users visible-xs"></i>
            </th>
            <th class="hidden-xs">{{ trans('campaigns.roles.fields.type') }}</th>
            <th class="hidden-xs">{{ trans('campaigns.roles.fields.permissions') }}</th>
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
                <td><a href="{{ route('campaign_roles.show', ['campaign_role' => $relation]) }}">{{ $relation->name }}</a></td>
                <td>{{ $relation->users->count() }}</td>
                <td class="hidden-xs">{{ trans('campaigns.roles.types.' . ($relation->is_admin ? 'owner' : ($relation->is_public ? 'public' : 'standard'))) }}</td>
                <td class="hidden-xs">@if ($relation->is_admin)

                    @else
                        {{ $relation->permissions->count() }}
                @endif</td>

                <td class="text-right">
                    <a href="{{ route('campaign_roles.show', ['campaign_role' => $relation]) }}" class="btn btn-xs btn-default" title="{{ trans('crud.manage') }}">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </a>
                    @can('update', $relation)
                        <a href="{{ route('campaign_roles.edit', ['campaign_role' => $relation]) }}" class="btn btn-xs btn-primary"
                           title="{{ trans('crud.edit') }}"
                           data-toggle="ajax-modal" data-target="#entity-modal"
                           data-url="{{ route('campaign_roles.edit', ['campaign_role' => $relation]) }}"
                        >
                            <i class="fa fa-edit" aria-hidden="true"></i>
                        </a>
                    @endcan
                    @can('delete', $relation)
                        <button class="btn btn-xs btn-danger delete-confirm" title="{{ trans('crud.remove') }}"
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
        {{ trans('campaigns.roles.actions.add') }}
    </a>
@endif
</div>

