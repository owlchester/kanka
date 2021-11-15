<?php
/**
 * @var \App\Models\Organisation $model
 * @var \App\Models\Organisation $r
 */
?><div class="box box-solid" id="organisation-suborganisations">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('organisations.show.tabs.organisations') }}
        </h3>
    </div>
    <div class="box-body">

        <p class="help-block">{{ __('organisations.helpers.descendants') }}</p>

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#organisation-suborganisations'])

    <?php $r = $model->descendants()->with('parent')->simpleSort($datagridSorter)->paginate(); ?>

        <table id="organisations" class="table table-hover ">
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
