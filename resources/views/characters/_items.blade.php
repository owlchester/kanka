<?php $r = $model->items()->paginate(); ?>
<p class="export-hidden">{{ trans('characters.items.hint') }}</p>
<p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('characters.show.tabs.items') }}</p>

<table id="character-items" class="table table-hover {{ ($r->count() === 0 ? 'export-hidden' : '') }}">
    <tbody><tr>
        <th class="avatar"></th>
        <th>{{ trans('items.fields.name') }}</th>
        <th>{{ trans('items.fields.type') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r as $item)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $item->getImageUrl(true) }}');" title="{{ $item->name }}" href="{{ route('items.show', $item->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('items.show', $item->id) }}" data-toggle="tooltip" title="{{ $item->tooltip() }}">{{ $item->name }}</a>
            </td>
            <td>{{ $item->type }}</td>
            <td class="text-right">
                @can('update', $item)
                    <a href="{{ route('items.edit', $item) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-pencil"></i> {{ trans('crud.edit') }}
                    </a>
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_items')->links() }}
