<table id="locations" class="table table-hover">
    <tbody><tr>
        <th><br /></th>
        <th>{{ trans('locations.fields.name') }}</th>
        <th>{{ trans('locations.fields.type') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $location->locations()->paginate() as $location)
        <tr>
            <td>
                @if ($location->image)
                    <img class="direct-chat-img" src="/storage/{{ $location->image }}" alt="{{ $location->name }} picture">
                @endif
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