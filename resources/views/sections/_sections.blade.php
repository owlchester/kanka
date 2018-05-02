<p>{{ trans('sections.hints.section') }}</p>
<table id="section-sections" class="table table-hover">
    <tbody><tr>
        <th class="avatar"><br /></th>
        <th>{{ trans('sections.fields.name') }}</th>
        <th>{{ trans('sections.fields.type') }}</th>
        <th>{{ trans('crud.fields.section') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->descendants()->with('section')->acl(auth()->user())->orderBy('name', 'ASC')->paginate() as $model)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(true) }}');" title="{{ $model->name }}" href="{{ route('sections.show', $model->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('sections.show', $model->id) }}" data-toggle="tooltip" title="{{ $model->tooltip() }}">{{ $model->name }}</a>
            </td>
            <td>
                {{ $model->type }}
            </td>
            <td>
                @if ($model->section)
                    <a href="{{ route('sections.show', $model->section->id) }}" data-toggle="tooltip" title="{{ $model->section->tooltip() }}">{{ $model->section->name }}</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $r->fragment('tab_sections')->links() }}