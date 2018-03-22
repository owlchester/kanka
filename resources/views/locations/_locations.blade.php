<table id="locations" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th>{{ trans('locations.fields.name') }}</th>
        <th>{{ trans('locations.fields.type') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->locations()->acl(auth()->user())->orderBy('name', 'ASC')->paginate() as $model)
        <tr>
            <td>
                <img class="direct-chat-img" src="{{ $model->getImageUrl(true) }}" alt="{{ $model->name }} picture">
            </td>
            <td>
                <a href="{{ route('locations.show', $model->id) }}">{{ $model->name }}</a>
            </td>
            <td>
                {{ $model->type }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $r->appends('tab', 'location')->links() }}