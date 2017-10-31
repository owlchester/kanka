
<table id="items" class="table table-hover">
    <tbody><tr>
        <th><br /></th>
        <th><a href="{{ route('items.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('items.fields.name') }}</a></th>
        <th><a href="{{ route('items.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('items.fields.type') }}</a></th>
        <th>{{ trans('items.fields.location') }}</th>
        <th>{{ trans('items.fields.character') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($models as $model)
        <tr>
            <td>
                @if ($model->image)
                    <img class="direct-chat-img" src="/storage/{{ $model->image }}" alt="{{ $model->name }} picture">
                @endif
            </td>
            <td>
                <a href="{{ route('items.show', $model->id) }}">{{ $model->name }}</a>
            </td>
            <td>{{ $model->type }}</td>
            <td>
                @if ($model->location)
                    <a href="{{ route('locations.show', $model->location_id) }}">{{ $model->location->name }}</a>
                @endif
            </td>
            <td>
                @if ($model->character)
                    <a href="{{ route('characters.show', $model->character_id) }}">{{ $model->character->name }}</a>
                @endif
            </td>
            <td class="text-right">
                <a href="{{ route('items.show', ['id' => $model->id]) }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody></table>