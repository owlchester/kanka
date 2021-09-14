<?php
/**
 * @var \App\Models\Organisation $model
 * @var \App\Models\Organisation $r
 */
?><div class="box box-solid" id="organisation-suborganisations">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('organisations.show.tabs.organisations') }}
        </h2>

        <p class="help-block">{{ __('organisations.helpers.descendants') }}</p>

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#organisation-suborganisations'])

    <?php $r = $model->descendants()->with('parent')->simpleSort($datagridSorter)->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ __('organisations.show.tabs.organisations') }}</p>
        <table id="organisations" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('organisations.fields.name') }}</th>
                <th>{{ __('organisations.fields.type') }}</th>
                <th>{{ __('crud.fields.organisation') }}</th>
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

        {{ $r->fragment('organisation-suborganisations')->links() }}
    </div>
</div>
