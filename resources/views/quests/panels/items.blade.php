<?php /** @var \App\Models\QuestItem $item */?>
<div class="row export-hidden">
    <div class="col-md-6">
        @include('cruds.datagrids.sorters.simple-sorter')
    </div>
    <div class="col-md-6 text-right">
        @can('update', $model)
            <a href="{{ route('quests.quest_items.create', ['quest' => $model->id]) }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('quests.show.actions.add_item') }}
            </a>
        @endcan
    </div>
</div>
<br />

<div class="row">
    @foreach ($model->items()->with('item')->has('item')->simpleSort($datagridSorter)->get() as $item)
        <div class="col-md-6">
            <div class="box box-widget widget-user-2 box-quest-element">
                <div class="widget-user-header {{ $item->colourClass() }}">
                        <div class="widget-user-image">
                            <div class="entity-image" style="background-image: url({{ $item->item->getImageUrl(65) }})" title="{{ $item->item->name }}">
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
                        <a href="{{ route('quests.quest_items.edit', [$model, $item]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-edit" title="{{ trans('crud.edit') }}"></i>
                        </a>
                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $item->item->name }}"
                                data-target="#delete-confirm" data-delete-target="delete-form-{{ $item->id }}"
                                title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => [
                                'quests.quest_items.destroy',
                                $model,
                                $item
                            ],
                            'style'=>'display:inline',
                            'id' => 'delete-form-' . $item->id
                        ]) !!}
                        {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>
    @endforeach
</div>
