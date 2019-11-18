<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('quests.show.tabs.organisations') }}
        </h2>

        <div class="row export-hidden">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter')
            </div>
            <div class="col-md-6 text-right">
                @can('update', $model)
                    <a href="{{ route('quests.quest_organisations.create', ['quest' => $model->id]) }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> {{ trans('quests.show.actions.add_organisation') }}
                    </a>
                @endcan
            </div>
        </div>
        <br />

        <div class="row">
            @foreach ($model->organisations()->with('organisation')->has('organisation')->simpleSort($datagridSorter)->get() as $organisation)
                <div class="col-md-6">
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-success">
                                <div class="widget-user-image">
                                    <div class="entity-image" style="background: url({{ $organisation->organisation->getImageUrl(true) }})" title="{{ $organisation->organisation->name }}">
                                    </div>
                                </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">
                                @if ($organisation->is_private)
                                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                                @endif
                                {!! $organisation->organisation->tooltipedLink() !!}
                            </h3>
                            <h5 class="widget-user-desc">{{ $organisation->role }}<br /></h5>
                        </div>
                        <div class="box-body">
                            <p>{!! $organisation->entry() !!}</p>
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
            @endforeach
        </div>
    </div>
</div>