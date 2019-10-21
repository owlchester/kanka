<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('quests.show.tabs.locations') }}
        </h2>
        @can('update', $model)
        <p class="text-right">
            <a href="{{ route('quests.quest_locations.create', ['quest' => $model->id]) }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('quests.show.actions.add_location') }}
            </a>
        </p>
        @endcan

        <div class="row">
            @foreach ($model->locations()->with('location')->has('location')->get() as $location)
                <div class="col-md-6">
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-success">
                                <div class="widget-user-image">
                                    <div class="entity-image" style="background: url({{ $location->location->getImageUrl(true) }})" title="{{ $location->location->name }}">
                                    </div>
                                </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">
                                @if ($location->is_private)
                                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                                @endif
                                {!! $location->location->tooltipedLink() !!}
                            </h3>
                            <h5 class="widget-user-desc">{{ $location->role }}<br /></h5>
                        </div>
                        <div class="box-body">
                            <p>{!! $location->entry() !!}</p>
                        </div>
                        <div class="box-footer text-right">
                            @can('update', $model)
                                <a href="{{ route('quests.quest_locations.edit', ['quest' => $model, 'questLocation' => $location]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-edit"></i> {{ trans('crud.edit') }}
                                </a>
                                {!! Form::open(['method' => 'DELETE','route' => ['quests.quest_locations.destroy', 'quest' => $model, 'questLocation' => $location],'style'=>'display:inline']) !!}                <button class="btn btn-xs btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                                </button>
                                {!! Form::close() !!}
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>