@if (Auth::user()->can('create', 'App\Models\LocationAttribute'))
    <p class="text-right">
        <a href="{{ route('locations.location_attributes.create', ['location' => $model->id]) }}" class="btn btn-primary">
            {{ trans('locations.attributes.actions.add') }}
        </a>
    </p>
@endif

<table id="locations" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('locations.attributes.fields.attribute') }}</th>
        <th>{{ trans('locations.attributes.fields.value') }}</th>
        @if (!Auth::user()->viewer())
            <th>{{ trans('locations.attributes.fields.is_private') }}</th>
        @endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->attributes()->orderBy('attribute', 'ASC')->paginate() as $attribute)
        <tr>
            <td>{{ $attribute->attribute }}</td>
            <td>{{ $attribute->value }}</td>
            @if (!Auth::user()->viewer())
                <td>
                    @if ($attribute->is_private == true)
                        <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                    @endif
                </td>
            @endif
            <td class="text-right">
                @if (Auth::user()->can('update', $attribute))
                    <a href="{{ route('locations.location_attributes.edit', ['location' => $model, 'locationAttribute' => $attribute]) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> {{ trans('crud.edit') }}</a>
                @endif
                @if (Auth::user()->can('delete', $attribute))
                {!! Form::open(['method' => 'DELETE','route' => ['locations.location_attributes.destroy', 'location' => $model, 'locationAttribute' => $attribute],'style'=>'display:inline']) !!}                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->appends('tab', 'attribute')->links() }}
