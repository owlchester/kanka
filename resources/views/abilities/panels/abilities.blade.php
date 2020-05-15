<?php
$filters = [];
if (request()->has('ability_id')) {
$filters['ability_id'] = request()->get('ability_id');
}
?>
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('abilities.show.tabs.abilities') }}
        </h2>

        <p class="help-block">{{ trans('abilities.helpers.descendants') }}</p>

        <div class="row export-hidden">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter')
            </div>
            <div class="col-md-6 text-right">
                @if (request()->has('ability_id'))
                    <a href="{{ route('abilities.abilities', $model) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants->count() }})
                    </a>
                @else
                    <a href="{{ route('abilities.abilities', [$model, 'ability_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->abilities->count() }})
                    </a>
                @endif
            </div>
        </div>

        <?php $r = $model->descendants()->filter($filters)->simpleSort($datagridSorter)->with('parent')->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('abilities.show.tabs.abilities') }}</p>
        <table id="abilities" class="table table-hover margin-top {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('abilities.fields.name') }}</th>
                <th>{{ trans('crud.fields.ability') }}</th>
                @if ($campaign->enabled('locations'))
                <th>{{ trans('crud.fields.location') }}</th>
                @endif
            </tr>
            @foreach ($r as $ability)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $ability->getImageUrl(40) }}');" title="{{ $ability->name }}" href="{{ route('abilities.show', $ability->id) }}"></a>
                    </td>
                    <td>
                        {!! $ability->tooltipedLink() !!}
                    </td>
                    <td>
                        @if ($ability->parent)
                            {!! $ability->parent->tooltipedLink() !!}
                        @endif
                    </td>
                    @if ($campaign->enabled('locations'))
                    <td>
                        @if ($ability->location)
                            {!! $ability->location->tooltipedLink() !!}
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
