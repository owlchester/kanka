<table id="locations" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th>{{ trans('locations.fields.name') }}</th>
        <th>{{ trans('locations.fields.type') }}</th>
        <th>{{ trans('crud.fields.location') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->descendants()->with('parent')->acl(auth()->user())->orderBy('name', 'ASC')->paginate() as $model)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(true) }}');" title="{{ $model->name }}" href="{{ route('locations.show', $model->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('locations.show', $model->id) }}" data-toggle="tooltip" title="{{ $model->tooltip() }}">{{ $model->name }}</a>
            </td>
            <td>
                {{ $model->type }}
            </td>
            <td>
                @if ($model->parent)
                    <a href="{{ route('locations.show', $model->parent->id) }}" data-toggle="tooltip" title="{{ $model->parent->tooltip() }}">{{ $model->parent->name }}</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $r->fragment('tab_location')->links() }}