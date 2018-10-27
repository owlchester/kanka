<p>{{ trans('tags.hints.tag') }}</p>
<table id="section-sections" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th>{{ trans('tags.fields.name') }}</th>
        <th>{{ trans('tags.fields.type') }}</th>
        <th>{{ trans('crud.fields.tag') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->descendants()->with('tag')->acl()->orderBy('name', 'ASC')->paginate() as $model)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(true) }}');" title="{{ $model->name }}" href="{{ route('tags.show', $model->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('tags.show', $model->id) }}" data-toggle="tooltip" title="{{ $model->tooltip() }}">{{ $model->name }}</a>
            </td>
            <td>
                {{ $model->type }}
            </td>
            <td>
                @if ($model->tag)
                    <a href="{{ route('tags.show', $model->tag->id) }}" data-toggle="tooltip" title="{{ $model->tag->tooltip() }}">{{ $model->tag->name }}</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $r->fragment('tab_tags')->links() }}