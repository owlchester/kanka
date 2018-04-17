<table id="character-items" class="table table-hover">
    <tbody><tr>
        <th class="avatar"></th>
        <th>{{ trans('items.fields.name') }}</th>
        <th>{{ trans('items.fields.type') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->items()->paginate() as $item)
        <tr>
            <td>
                <img class="direct-chat-img" src="{{ $item->getImageUrl(true) }}" alt="{{ $item->name }} picture">
            </td>
            <td>
                <a href="{{ route('items.show', $item->id) }}">{{ $item->name }}</a>
            </td>
            <td>{{ $item->type }}</td>
            <td class="text-right">
                @can('update', $item)
                    <a href="{{ route('items.edit', $item) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-pencil"></i> {{ trans('crud.edit') }}
                    </a>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->appends('tab', 'items')->links() }}
