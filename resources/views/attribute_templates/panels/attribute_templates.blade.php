<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('attribute_templates.show.tabs.attribute_templates') }}
        </h2>

        <?php  $r = $model->descendants()->orderBy('name', 'ASC')->with(['entity', 'attributeTemplate'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('attribute_templates.show.tabs.attribute_templates') }}</p>
        <table id="attribute_templates" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('attribute_templates.fields.name') }}</th>
                <th>{{ trans('attribute_templates.fields.attribute_template') }}</th>
                <th>{{ trans('attribute_templates.fields.attributes') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $template)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $template->getImageUrl(true) }}');" title="{{ $template->name }}" href="{{ route('characters.show', $template->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('attribute_templates.show', $template->id) }}" data-toggle="tooltip" title="{{ $template->tooltip() }}">{{ $template->name }}</a>
                    </td>
                    <td>
                        @if ($template->attributeTemplate)
                            <a href="{{ route('attribute_templates.show', $template->attributeTemplate->id) }}" data-toggle="tooltip" title="{{ $template->attributeTemplate->tooltip() }}">{{ $template->attributeTemplate->name }}</a>
                        @endif
                    </td>
                    <td>
                        {{ $template->entity->attributes->count() }}
                    </td>
                    <td class="text-right">
                        <a href="{{ route('characters.show', [$template]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
