<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('quests.show.tabs.items') }}
        </h2>
        @can('update', $model)
        <p class="text-right">
            <a href="{{ route('quests.quest_items.create', ['quest' => $model->id]) }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('quests.show.actions.add_item') }}
            </a>
        </p>
        @endcan

        <div class="row">
            @foreach ($model->items()->with('item')->has('item')->get() as $item)
                <div class="col-md-6">
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-success">
                                <div class="widget-user-image">
                                    <div class="entity-image" style="background: url({{ $item->item->getImageUrl(true) }})" title="{{ $item->item->name }}">
                                    </div>
                                </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">
                                @if ($item->is_private)
                                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                                @endif
                                {!! $item->item->tooltipedLink() !!}
                            </h3>
                            <h5 class="widget-user-desc">{{ $item->role }}<br /></h5>
                        </div>
                        <div class="box-body">
                            <p>{!! $item->entry() !!}</p>
                        </div>
                        <div class="box-footer text-right">
                            @can('update', $model)
                                <a href="{{ route('quests.quest_items.edit', ['quest' => $model, 'questItem' => $item]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-edit"></i> {{ trans('crud.edit') }}
                                </a>
                                {!! Form::open(['method' => 'DELETE','route' => ['quests.quest_items.destroy', 'quest' => $model, 'questItem' => $item],'style'=>'display:inline']) !!}                <button class="btn btn-xs btn-danger">
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