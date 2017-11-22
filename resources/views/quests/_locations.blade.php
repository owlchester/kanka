@if (Auth::user()->can('create', 'App\Models\QuestLocation'))
<p class="text-right">
    <a href="{{ route('quests.quest_locations.create', ['quest' => $model->id]) }}" class="btn btn-primary">
        {{ trans('quests.show.actions.add_location') }}
    </a>
</p>
@endif

<div class="row">
    @foreach ($model->locations()->with('location')->get() as $location)
        @if ($location->location)
        <div class="col-md-6">
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-success">
                    @if ($location->location->image)
                        <img class="direct-chat-img" src="{{ $model->getImageUrl(true) }}" alt="{{ $model->name }}">
                    @endif
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">
                        <a href="{{ route('locations.show', $location->location) }}">
                            {{ $location->location->name }}
                        </a>
                        @if ($location->is_private)
                            <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                        @endif
                    </h3>
                </div>
                <div class="box-body">
                    <p>{!! $location->description !!}</p>
                </div>
                <div class="box-footer text-right">
                    @if (Auth::user()->can('update', $location))
                        <a href="{{ route('quests.quest_locations.edit', ['quest' => $model, 'questLocation' => $location]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-pencil"></i> {{ trans('crud.edit') }}
                        </a>
                    @endif
                    @if (Auth::user()->can('delete', $location))
                        {!! Form::open(['method' => 'DELETE','route' => ['quests.quest_locations.destroy', 'quest' => $model, 'questLocation' => $location],'style'=>'display:inline']) !!}                <button class="btn btn-xs btn-danger">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                        </button>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>