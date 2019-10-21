<?php /** @var \App\Models\QuestCharacter $character */?>
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('quests.show.tabs.characters') }}
        </h2>
        @can('update', $model)
        <p class="text-right">
            <a href="{{ route('quests.quest_characters.create', ['quest' => $model->id]) }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('quests.show.actions.add_character') }}
            </a>
        </p>
        @endcan

        <div class="row">
            @foreach ($model->characters()->with(['character', 'character.entity', 'character.entity.tags'])->has('character')->get() as $character)
                <div class="col-md-6">
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-success">
                                <div class="widget-user-image">
                                    <div class="entity-image" style="background: url({{ $character->character->getImageUrl(true) }})" title="{{ $character->character->name }}">
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
                                <a href="{{ route('quests.quest_characters.edit', ['quest' => $model, 'questCharacter' => $character]) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-edit"></i> {{ trans('crud.edit') }}
                                </a>
                                {!! Form::open(['method' => 'DELETE','route' => ['quests.quest_characters.destroy', 'quest' => $model, 'questCharacter' => $character],'style'=>'display:inline']) !!}                <button class="btn btn-xs btn-danger">
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