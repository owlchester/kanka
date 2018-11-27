<div class="box box-flat">
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
            @foreach ($model->characters()->acl()->with('character')->get() as $character)
                @if ($character->character)
                <div class="col-md-6">
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-success">
                            @if ($character->character->image)
                                <img class="direct-chat-img" src="{{ $character->character->getImageUrl(true) }}" alt="{{ $character->character->name }}">
                            @endif

                            <h3 class="widget-user-username">
                                <a href="{{ route('characters.show', $character->character) }}" data-toggle="tooltip" title="{{ $character->character->tooltip() }}">
                                    {{ $character->character->name }}
                                </a>
                                @if ($character->is_private)
                                    <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                                @endif
                            </h3>
                        </div>
                        <div class="box-body">
                            <p>{!! $character->description !!}</p>
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
                @endif
            @endforeach
        </div>
    </div>
</div>