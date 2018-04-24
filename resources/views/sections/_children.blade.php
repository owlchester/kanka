<table id="section-children" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th>{{ trans('crud.fields.name') }}</th>
    </tr>
    @foreach ($model->allChildren() as $model)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(true) }}');" title="{{ $model->name }}" href="{{ route($model->entity->pluralType() . '.show', $model->id) }}"></a>
            </td>
            <td>
                <a href="{{ route($model->entity->pluralType() . '.show', $model->id) }}" data-toggle="tooltip" title="{{ $model->tooltip() }}">
                    {{ $model->name }}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
