    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
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

                    {!! Form::open(['method' => 'DELETE','route' => ['campaigns.destroy', $campaign->id],'style'=>'display:inline']) !!}
                    <button class="btn btn-block btn-danger">
                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                    </button>
                    {!! Form::close() !!}
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

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