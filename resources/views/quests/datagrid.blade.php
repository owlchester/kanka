
<table id="quests" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th><a href="{{ route('quests.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('quests.fields.name') }}</a></th>
        <th><a href="{{ route('quests.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('quests.fields.type') }}</a></th>
        @if ($campaign->enabled('characters'))<th>{{ trans('quests.fields.characters') }}</th>@endif
        @if ($campaign->enabled('locations'))<th>{{ trans('quests.fields.locations') }}</th>@endif
        @if (!Auth::user()->viewer())
            <th><a href="{{ route('quests.index', ['order' => 'is_private', 'page' => request()->get('page')]) }}">{{ trans('crud.fields.is_private') }}</a></th>
        @endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($models as $model)
        <tr>
            <td>
                @if ($model->image)
                <img class="direct-chat-img" src="{{ $model->getImageUrl(true) }}" alt="{{ $model->name }} picture">
                @endif
            </td>
            <td>
                <a href="{{ route('quests.show', $model->id) }}">{{ $model->name }}</a>
            </td>
            <td>{{ $model->type }}</td>
            @if ($campaign->enabled('characters'))
            <td>{{ $model->characters()->count() }}</td>
            @endif
            @if ($campaign->enabled('locations'))
            <td>{{ $model->locations()->with('location')->count() }}</td>
            @endif
            @if (!Auth::user()->viewer())
                <td>
                    @if ($model->is_private == true)
                        <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                    @endif
                </td>
            @endif
            <td class="text-right">
                <a href="{{ route('quests.show', ['id' => $model->id]) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
                @if (Auth::user()->can('update', $model))
                    <a href="{{ route('quests.edit', ['id' => $model->id]) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.edit') }}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody></table>