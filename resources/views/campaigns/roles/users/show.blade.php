@extends('layouts.app', [
    'title' => trans('campaigns.roles.show.title'),
    'description' => trans('campaigns.roles.show.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index', ['tab' => 'roles']), 'label' => trans('campaigns.index.title')]
    ]
])

@section('content')
    @include('partials.errors')

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('campaigns.roles.members') }}</h3>
                </div>
                <div class="box-body">
                    @if (Auth::user()->can('user', $role))
                        <p class="text-right">
                            <a href="{{ route('campaign_roles.campaign_role_users.create', ['campaign_role' => $role]) }}" class="btn btn-primary">
                                {{ trans('campaigns.roles.users.actions.add') }}
                            </a>
                        </p>
                    @endif
                    <table id="characters" class="table table-hover">
                        <tbody><tr>
                            <th>{{ trans('campaigns.roles.users.fields.name') }}</th>
                            <th><br /></th>
                        </tr>
                        <?php $r = $role->users()->paginate();?>
                        @foreach ($r as $relation)
                            <tr>
                                <td>{{ $r->name }}</td>
                                <td class="text-right">
                                    @if (Auth::user()->can('user', $role))
                                        <a href="{{ route('campaign_roles.campaign_role_users.edit', ['campaign_role' => $role, 'campaign_role_user' => $relation]) }}" class="btn btn-xs btn-primary">
                                            <i class="fa fa-pencil"></i> {{ trans('crud.edit') }}
                                        </a>

                                        {!! Form::open(['method' => 'DELETE', 'route' => 'campaign_roles.campaign_role_users.destroy', ['campaign_role' => $role, 'campaign_role_user' => $relation], 'style'=>'display:inline']) !!}
                                        <button class="btn btn-xs btn-danger">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                                        </button>
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody></table>
                    {{ $r->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
