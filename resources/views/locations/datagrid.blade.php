<table id="locations" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th><a href="{{ route('locations.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('locations.fields.name') }}</a></th>
        <th><a href="{{ route('locations.index', ['order' => 'type', 'page' => request()->get('page')]) }}">{{ trans('locations.fields.type') }}</a></th>
        <th>{{ trans('locations.fields.location') }}</th>
        <th>{{ trans('locations.fields.characters') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($models as $model)
        <tr>
            <td>
                <img class="direct-chat-img" src="{{ $model->getImageUrl(true) }}" alt="{{ $model->name }} picture">
            </td>
            <td>
                <a href="{{ route('locations.show', $model->id) }}">{{ $model->name }}</a>
            </td>
            <td>{{ $model->type }}</td>
            <td>
                @if ($model->parentLocation)
                    <a href="{{ route('locations.show', $model->parentLocation->id) }}">{{ $model->parentLocation->name }}</a>
                @endif
            </td>
            <td>{{ $model->characters()->count() }}</td>
            <td class="text-right">
                <a href="{{ route('locations.show', ['id' => $model->id]) }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody></table>