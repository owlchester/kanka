<?php /** @var \App\Models\QuestLocation $location */?>
<div class="row export-hidden">
    <div class="col-md-6">
        @include('cruds.datagrids.sorters.simple-sorter')
    </div>
    <div class="col-md-6 text-right">
        @can('update', $model)
            <a href="{{ route('quests.quest_locations.create', ['quest' => $model->id]) }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('quests.show.actions.add_location') }}
            </a>
        @endcan
    </div>
</div>
<br />

<div class="row">
    @foreach ($model->locations()->with('location')->has('location')->simpleSort($datagridSorter)->get() as $location)
        <div class="col-md-6">
            <div class="box box-widget widget-user-2 box-quest-element">
                <div class="widget-user-header {{ $location->colourClass() }}">
                        <div class="widget-user-image">
                            <div class="entity-image" style="background-image: url({{ $location->location->getImageUrl(65) }})" title="{{ $location->location->name }}">
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
                        <a href="{{ route('quests.quest_locations.edit', [$model, $location]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-edit" title="{{ trans('crud.edit') }}"></i>
                        </a>
                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $location->location->name }}"
                                    data-target="#delete-confirm" data-delete-target="delete-form-{{ $location->id }}"
                                    title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => [
                                'quests.quest_locations.destroy',
                                $model,
                                $location
                            ],
                            'style'=>'display:inline',
                            'id' => 'delete-form-' . $location->id
                        ]) !!}
                        {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>
    @endforeach
</div>
