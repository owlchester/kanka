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
            @foreach ($model->items()->acl()->with('item')->get() as $item)
                @if ($item->item)
                <div class="col-md-6">
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-success">
                            @if ($item->item->image)
                                <img class="direct-chat-img" src="{{ $item->item->getImageUrl(true) }}" alt="{{ $item->item->name }}">
                            @endif
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">
                                <a href="{{ route('items.show', $item->item) }}" data-toggle="tooltip" title="{{ $item->item->tooltipWithName() }}" data-html="true">
                                    {{ $item->item->name }}
                                </a>
                                @if ($item->is_private)
                                    <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
                                @endif
                            </h3>
                        </div>
                        <div class="box-body">
                            <p>{!! $item->description !!}</p>
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
                @endif
            @endforeach
        </div>
    </div>
</div>