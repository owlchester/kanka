
<table id="items" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th><a href="{{ route('items.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('items.fields.name') }}</a></th>
        <th><a href="{{ route('items.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('items.fields.type') }}</a></th>
        @if ($campaign->enabled('locations'))<th>{{ trans('items.fields.location') }}</th>@endif
        @if ($campaign->enabled('characters'))<th>{{ trans('items.fields.character') }}</th>@endif
        @if (!Auth::user()->viewer())
            <th><a href="{{ route('items.index', ['order' => 'is_private', 'page' => request()->get('page')]) }}">{{ trans('crud.fields.is_private') }}</a></th>
        @endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($models as $model)
        <tr>
            <td>
                <img class="direct-chat-img" src="{{ $model->getImageUrl(true) }}" alt="{{ $model->name }} picture">
            </td>
            <td>
                <a href="{{ route('items.show', $model->id) }}">{{ $model->name }}</a>
            </td>
            <td>{{ $model->type }}</td>
            @if ($campaign->enabled('locations'))
            <td>
                @if ($model->location)
                    <a href="{{ route('locations.show', $model->location_id) }}">{{ $model->location->name }}</a>
                @endif
            </td>
            @endif
            @if ($campaign->enabled('characters'))
            <td>
                @if ($model->character)
                    <a href="{{ route('characters.show', $model->character_id) }}">{{ $model->character->name }}</a>
                @endif
            </td>
            @endif
            @if (!Auth::user()->viewer())
                <td>
                    @if ($model->is_private == true)
                        <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                    @endif
                </td>
            @endif
            <td class="text-right">
                <a href="{{ route('items.show', ['id' => $model->id]) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
                @if (Auth::user()->can('update', $model))
                    <a href="{{ route('items.edit', ['id' => $model->id]) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.edit') }}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody></table>