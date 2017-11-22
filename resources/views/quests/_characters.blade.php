@if (Auth::user()->can('create', 'App\Models\QuestCharacter'))
<p class="text-right">
    <a href="{{ route('quests.quest_characters.create', ['quest' => $model->id]) }}" class="btn btn-primary">
        {{ trans('quests.show.actions.add_character') }}
    </a>
</p>
@endif

<div class="row">
    @foreach ($model->characters()->with('character')->get() as $character)
        @if ($character->character)
        <div class="col-md-6">
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-success">
                    @if ($character->character->image)
                        <img class="direct-chat-img" src="{{ $model->getImageUrl(true) }}" alt="{{ $model->name }}">
                @endif
                <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">
                        <a href="{{ route('characters.show', $character->character) }}">
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
                    @if (Auth::user()->can('update', $character))
                        <a href="{{ route('quests.quest_characters.edit', ['quest' => $model, 'questCharacter' => $character]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-pencil"></i> {{ trans('crud.edit') }}
                        </a>
                    @endif
                    @if (Auth::user()->can('delete', $character))
                        {!! Form::open(['method' => 'DELETE','route' => ['quests.quest_characters.destroy', 'quest' => $model, 'questCharacter' => $character],'style'=>'display:inline']) !!}                <button class="btn btn-xs btn-danger">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                        </button>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>