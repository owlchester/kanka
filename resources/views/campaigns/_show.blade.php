<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box">
            <div class="box-body box-profile">
                @if ($campaign->image)
                    <a href="{{ Storage::url($campaign->image) }}" title="{{ $campaign->name }}" target="_blank">
                        <img class="profile-user-img img-responsive img-circle" src="{{ Storage::url($campaign->image) }}" alt="{{ $campaign->name }} picture">
                    </a>
                @endif

                <h1 class="profile-username text-center">{{ $campaign->name }}</h1>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>{{ trans('campaigns.fields.visibility') }}</b>
                        <span  class="pull-right">
                            {{ trans('campaigns.visibilities.' . $campaign->visibility) }}
                        </span>
                        <br class="clear" />
                    </li>
                    <li class="list-group-item">
                        <b>{{ trans('campaigns.fields.locale') }}</b>
                        <span  class="pull-right">
                            {{ trans('languages.codes.' . $campaign->locale) }}
                        </span>
                        <br class="clear" />
                    </li>
                </ul>

                @can('update', $campaign)
                <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-primary btn-block">
                    <i class="fa fa-edit" aria-hidden="true"></i> {{ trans('crud.update') }}
                </a>
                @endcan
                @can('leave', $campaign)
                <button data-url="{{ route('campaigns.leave', $campaign->id) }}" class="btn btn-warning btn-block click-confirm" data-toggle="modal" data-target="#click-confirm" data-message="{{ trans('campaigns.leave.confirm', ['name' => $campaign->name]) }}">
                    <i class="fa fa-sign-out" aria-hidden="true"></i> {{ trans('campaigns.show.actions.leave') }}
                </button>
                @endcan

                @can('delete', $campaign)
                <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $campaign->name }}" data-toggle="modal" data-target="#delete-confirm">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::open(['method' => 'DELETE','route' => ['campaigns.destroy', $campaign->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                {!! Form::close() !!}
                {!! Form::close() !!}
                @endcan
            </div>
        </div>

    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#entry" data-toggle="tooltip" title="{{ trans('crud.panels.entry') }}">
                        <span class="fa fa-align-justify"></span> <span class="hidden-xs hidden-sm">{{ trans('crud.panels.entry') }}</span>
                    </a>
                </li>
                <li class="">
                    <a href="#member">
                        <span class="fa fa-users"></span> <span class="hidden-xs hidden-sm">{{ trans('campaigns.show.tabs.members') }}</span>
                    </a>
                </li>
                @can('update', $campaign)
                <li class="">
                    <a href="#roles">
                        <span class="fas fa-lock"></span> <span class="hidden-xs hidden-sm">{{ trans('campaigns.show.tabs.roles') }}</span>
                    </a>
                </li>
                <li class="">
                    <a href="#setting">
                        <span class="fa fa-cubes"></span> <span class="hidden-xs hidden-sm">{{ trans('campaigns.show.tabs.settings') }}</span>
                    </a>
                </li>
                <li class="">
                    <a href="#export">
                        <span class="fa fa-download"></span> <span class="hidden-xs hidden-sm">{{ trans('campaigns.show.tabs.export') }}</span>
                    </a>
                </li>
                @endcan
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="entry">
                    <div class="post">
                        <p>{!! $campaign->entry() !!}</p>
                    </div>
                </div>
                <div class="tab-pane" id="member">
                    @include('campaigns._members')
                </div>
                @can('update', $campaign)
                <div class="tab-pane" id="roles">
                    @include('campaigns._roles')
                </div>
                <div class="tab-pane" id="setting">
                    @include('campaigns._settings')
                </div>
                <div class="tab-pane" id="export">
                    @include('campaigns._export')
                </div>
                @endcan
            </div>
        </div>

        <!-- actions -->
    </div>
</div>
