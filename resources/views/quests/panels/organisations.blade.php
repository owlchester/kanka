<?php /** @var \App\Models\QuestOrganisation $organisation */?>
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
            <div class="box box-widget widget-user-2 box-quest-element">
                <div class="widget-user-header {{ $organisation->colourClass() }}">
                        <div class="widget-user-image">
                            <div class="entity-image" style="background-image: url({{ $organisation->organisation->getImageUrl(65) }})" title="{{ $organisation->organisation->name }}">
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
                        <a href="{{ route('quests.quest_organisations.edit', [$model, $organisation]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-edit" title="{{ trans('crud.edit') }}"></i>
                        </a>
                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $organisation->organisation->name }}"
                                    data-target="#delete-confirm" data-delete-target="delete-form-{{ $organisation->id }}"
                                    title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => [
                                'quests.quest_organisations.destroy',
                                $model,
                                $organisation
                            ],
                            'style'=>'display:inline',
                            'id' => 'delete-form-' . $organisation->id
                        ]) !!}
                        {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>
    @endforeach
</div>
