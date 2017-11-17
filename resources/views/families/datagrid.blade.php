<table id="families" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br></th>
        <th><a href="{{ route('families.index', ['order' => 'name', 'page' => request()->get('page')]) }}">{{ trans('families.fields.name') }}</a></th>
        @if ($campaign->enabled('locations'))<th>{{ trans('families.fields.location') }}</th>@endif
        <th>{{ trans('families.fields.members') }}</th>
        @if (!Auth::user()->viewer())
            <th><a href="{{ route('families.index', ['order' => 'is_private', 'page' => request()->get('page')]) }}">{{ trans('crud.fields.is_private') }}</a></th>
        @endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($models as $family)
        <tr>
            <td>
                <img class="direct-chat-img" src="{{ $family->getImageUrl(true) }}" alt="{{ $family->name }} picture">
            </td>
            <td>
                <a href="{{ route('families.show', $family->id) }}">{{ $family->name }}</a>
            </td>
            @if ($campaign->enabled('locations'))<td>
                @if ($family->location)
                    <a href="{{ route('locations.show', $family->location_id) }}">{{ $family->location->name }}</a>
                @endif
            </td>
            @endif
            <td>
                {{ $family->members()->count() }}
            </td>
            @if (!Auth::user()->viewer())
                <td>
                    @if ($family->is_private == true)
                        <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                    @endif
                </td>
            @endif
            <td class="text-right">
                <a href="{{ route('families.show', ['id' => $family->id]) }}" class="btn btn-xs btn-default">
                    <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                </a>
                @if (Auth::user()->can('update', $family))
                    <a href="{{ route('families.edit', ['id' => $family->id]) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-pencil" aria-hidden="true"></i> {{ trans('crud.edit') }}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody></table>