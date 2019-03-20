<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('quests.show.tabs.organisations') }}
        </h2>
        @can('update', $model)
        <p class="text-right">
            <a href="{{ route('quests.quest_organisations.create', ['quest' => $model->id]) }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('quests.show.actions.add_organisation') }}
            </a>
        </p>
        @endcan

        <div class="row">
            @foreach ($model->organisations()->acl()->with('organisation')->get() as $organisation)
                @if ($organisation->organisation)
                <div class="col-md-6">
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-success">
                            @if ($organisation->organisation->image)
                                <img class="direct-chat-img" src="{{ $organisation->organisation->getImageUrl(true) }}" alt="{{ $organisation->organisation->name }}">
                            @endif
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">
                                <a href="{{ route('organisations.show', $organisation->organisation) }}" data-toggle="tooltip" title="{{ $organisation->organisation->tooltip() }}">
                                    {{ $organisation->organisation->name }}
                                </a>
                                @if ($organisation->is_private)
                                    <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
                                @endif
                            </h3>
                        </div>
                        <div class="box-body">
                            <p>{!! $organisation->description !!}</p>
                        </div>
                        <div class="box-footer text-right">
                            @can('update', $model)
                                <a href="{{ route('quests.quest_organisations.edit', ['quest' => $model, 'questOrganisation' => $organisation]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-edit"></i> {{ trans('crud.edit') }}
                                </a>
                                {!! Form::open(['method' => 'DELETE','route' => ['quests.quest_organisations.destroy', 'quest' => $model, 'questOrganisation' => $organisation],'style'=>'display:inline']) !!}                <button class="btn btn-xs btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                                </button>
                                {!! Form::close() !!}
                            @endcan
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>