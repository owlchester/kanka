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

                <h3 class="profile-username text-center">{{ $campaign->name }}</h3>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>{{ trans('campaigns.fields.visibility') }}</b>
                        <span  class="pull-right">
                            {{ trans('campaigns.visibilities.' . $campaign->visibility) }}
                        </span>
                        <br class="clear" />
                    </li>
                </ul>

                @if (Auth::user()->can('update', $campaign))
                <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-primary btn-block">
                    <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                </a>
                @endif
                @if (Auth::user()->can('leave', $campaign))
                <button data-url="{{ route('campaigns.leave', $campaign->id) }}" class="btn btn-warning btn-block click-confirm" data-toggle="modal" data-target="#click-confirm" data-message="{{ trans('campaigns.leave.confirm', ['name' => $campaign->name]) }}">
                    <i class="fa fa-sign-out" aria-hidden="true"></i> {{ trans('campaigns.show.actions.leave') }}
                </button>
                @endif

                @if (Auth::user()->can('delete', $campaign))
                <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $campaign->name }}" data-toggle="modal" data-target="#delete-confirm">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::open(['method' => 'DELETE','route' => ['campaigns.destroy', $campaign->id], 'style'=>'display:inline', 'id' => 'delete-confirm-form']) !!}
                {!! Form::close() !!}
                {!! Form::close() !!}
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


        @if (!empty($campaigns))
            @foreach ($campaigns as $c)
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h4>{!! $c->shortName(50) !!}</h4>

                        </div>
                        <div class="icon">
                            <i class="ion ion-map"></i>
                        </div>
                        <a href="{{ url(App::getLocale() . '/campaign-' . $campaign->id) }}" class="small-box-footer">
                            <i class="fa fa-arrow-circle-right"></i> {{ trans('crud.select') }}
                        </a>
                    </div>
            @endforeach
        @endif

    <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h4>{{ trans('campaigns.index.actions.new.title') }}</h4>
            </div>
            <div class="icon">
                <i class="ion ion-plus"></i>
            </div>
            <a href="{{ route('campaigns.create') }}" class="small-box-footer">
                <i class="fa fa-plus-circle"></i> {{ trans('campaigns.index.actions.new.description') }}
            </a>
        </div>

    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#info">
                        <span class="fa fa-align-justify"></span> {{ trans('campaigns.show.tabs.information') }}
                    </a>
                </li>
                <li class="">
                    <a href="#member">
                        <span class="fa fa-users"></span> {{ trans('campaigns.show.tabs.members') }}
                    </a>
                </li>
                @can('update', $campaign)
                <li class="">
                    <a href="#roles">
                        <span class="fa fa-lock"></span> {{ trans('campaigns.show.tabs.roles') }}
                    </a>
                </li>
                @endcan
                @can('setting', $campaign)
                <li class="">
                    <a href="#setting">
                        <span class="fa fa-cubes"></span> {{ trans('campaigns.show.tabs.settings') }}
                    </a>
                </li>
                <li class="">
                    <a href="#export">
                        <span class="fa fa-download"></span> {{ trans('campaigns.show.tabs.export') }}
                    </a>
                </li>
                @endcan
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="info">
                    <div class="post">
                        <p>{!! $campaign->description !!}</p>
                    </div>
                </div>
                <div class="tab-pane" id="member">
                    @include('campaigns._members')
                </div>
                @can('update', $campaign)
                <div class="tab-pane" id="roles">
                    @include('campaigns._roles')
                </div>
                @endcan
                @can('setting', $campaign)
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