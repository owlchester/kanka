<table id="locations" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th>{{ trans('locations.fields.name') }}</th>
        <th>{{ trans('locations.fields.type') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $location->locations()->paginate() as $location)
        <tr>
            <td>
                <img class="direct-chat-img" src="{{ $location->getImageUrl(true) }}" alt="{{ $location->name }} picture">
            </td>
            <td>
                <a href="{{ route('locations.show', $location->id) }}">{{ $location->name }}</a>
            </td>
            <td>
                {{ $location->type }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $r->appends('tab', 'location')->links() }}