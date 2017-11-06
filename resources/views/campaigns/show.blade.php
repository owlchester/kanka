<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box">
            <div class="box-body box-profile">
                @if ($campaign->image)
                <a href="/storage/{{ $campaign->image }}">
                    <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $campaign->image }}" alt="{{ $campaign->name }} picture">
                </a>
                @endif

                <h3 class="profile-username text-center">{{ $campaign->name }}</h3>

                @if ($campaign->owner())
                <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-primary btn-block">
                    <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.update') }}
                </a>

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


        @foreach ($campaigns as $c)
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>{!! $c->shortName(50) !!}</h4>

                    </div>
                    <div class="icon">
                        <i class="ion ion-map"></i>
                    </div>
                    <a href="{{ route('campaigns.index', ['campaign_id' => $c->id]) }}" class="small-box-footer">
                        {{ trans('crud.select') }} <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
        @endforeach

    <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h4>{{ trans('campaigns.index.actions.new.title') }}</h4>
            </div>
            <div class="icon">
                <i class="ion ion-plus"></i>
            </div>
            <a href="{{ route('campaigns.create') }}" class="small-box-footer">
                {{ trans('campaigns.index.actions.new.description') }}<i class="fa fa-plus-circle"></i>
            </a>
        </div>

    </div>

    <div class="col-md-9">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}"><a href="#info" data-toggle="tab" aria-expanded="false">Information</a></li>
                <li class="{{ (request()->get('tab') == 'member' ? ' active' : '') }}"><a href="#member" data-toggle="tab" aria-expanded="false">Members</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="info">
                    <div class="post">
                        <p>{!! $campaign->description !!}</p>
                    </div>
                </div>
                <div class="tab-pane {{ (request()->get('tab') == 'member' ? ' active' : '') }}" id="member">
                    @include('campaigns._members')
                </div>
            </div>
        </div>

        <!-- actions -->
    </div>
</div>