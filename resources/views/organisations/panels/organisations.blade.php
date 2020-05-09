<?php
/**
 * @var \App\Models\Organisation $model
 * @var \App\Models\Organisation $r
 */
?><div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('organisations.show.tabs.organisations') }}
        </h2>

        <p class="help-block">{{ trans('organisations.helpers.descendants') }}</p>

        @include('cruds.datagrids.sorters.simple-sorter')

    <?php $r = $model->descendants()->with('parent')->simpleSort($datagridSorter)->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('organisations.show.tabs.organisations') }}</p>
        <table id="organisations" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('organisations.fields.name') }}</th>
                <th>{{ trans('organisations.fields.type') }}</th>
                <th>{{ trans('crud.fields.organisation') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $model)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(40) }}');" title="{{ $model->name }}" href="{{ route('organisations.show', $model->id) }}"></a>
                    </td>
                    <td>
                        {!! $model->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ $model->type }}
                    </td>
                    <td>
                        @if ($model->parent)
                            {!! $model->parent->tooltipedLink() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
