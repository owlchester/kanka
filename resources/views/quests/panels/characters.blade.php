<?php /** @var \App\Models\QuestCharacter $character */?>
<div class="row export-hidden">
    <div class="col-md-6">
        @include('cruds.datagrids.sorters.simple-sorter')
    </div>
    <div class="col-md-6 text-right">
        @can('update', $model)
            <a href="{{ route('quests.quest_characters.create', ['quest' => $model->id]) }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('quests.show.actions.add_character') }}
            </a>
        @endcan
    </div>
</div>
<div class="row margin-top">
    @foreach ($model->characters()->with(['character', 'character.entity', 'character.entity.tags'])->has('character')->simpleSort($datagridSorter)->get() as $character)
        <div class="col-md-6">
            <div class="box box-widget widget-user-2 box-quest-element">
                <div class="widget-user-header {{ $character->colourClass() }}">
                    <div class="widget-user-image">
                        <div class="entity-image" style="background-image: url({{ $character->character->getImageUrl(65) }})" title="{{ $character->character->name }}">
                        </div>
                    </div>

                    <h3 class="widget-user-username">
                        @if ($character->is_private)
                            <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                        @endif
                        {!! $character->character->tooltipedLink() !!}
                    </h3>
                    <h5 class="widget-user-desc">{{ $character->role }}<br /></h5>
                </div>
                <div class="box-body">
                    <p>{!! $character->entry() !!}</p>
                </div>
                <div class="box-footer text-right">
                    @can('update', $model)
                        <a href="{{ route('quests.quest_characters.edit', [$model, $character]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-edit" title="{{ trans('crud.edit') }}"></i>
                        </a>
                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $character->character->name }}"
                                data-target="#delete-confirm" data-delete-target="delete-form-{{ $character->id }}"
                                title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => [
                                'quests.quest_characters.destroy',
                                $model,
                                $character
                            ],
                            'style'=>'display:inline',
                            'id' => 'delete-form-' . $character->id
                        ]) !!}
                        {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>
    @endforeach
</div>
