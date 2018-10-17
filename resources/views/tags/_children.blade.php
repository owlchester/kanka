<p>{{ trans('tags.hints.children') }}</p>
<table id="section-children" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th>{{ trans('crud.fields.name') }}</th>
        <th>{{ trans('crud.fields.entity') }}</th>
    </tr>
    @foreach ($r = $model->allChildren()->orderBy('name', 'ASC')->paginate() as $model)
        <tr>
            @if ($model->child)
            <td>
                <a class="entity-image" style="background-image: url('{{ $model->child->getImageUrl(true) }}');" title="{{ $model->child->name }}" href="{{ route($model->pluralType() . '.show', $model->child->id) }}"></a>
            </td>
            <td>
                <a href="{{ route($model->pluralType() . '.show', $model->child->id) }}" data-toggle="tooltip" title="{{ $model->tooltip() }}">
                    {{ $model->child->name }}
                </a>
            </td>
            <td>
                {{ trans('entities.' . $model->pluralType()) }}
            </td>
            @else
            <td colspan="3">
                {{ trans('crud.is_private') }}
            </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

{{ $r->links() }}