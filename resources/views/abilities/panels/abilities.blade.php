<?php
$filters = [];
if (request()->has('ability_id')) {
    $filters['ability_id'] = request()->get('ability_id');
}
$r = $model->descendants()
        ->filter($filters)
        ->simpleSort($datagridSorter)
        ->with('parent')
        ->paginate();
?>
<div class="box box-solid" id="ability-abilities">
    <div class="box-body">
        <p class="help-block">{{ __('abilities.helpers.descendants') }}</p>

        <div class="row">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#ability-abilities'])
            </div>
            <div class="col-md-6 text-right">
                @if (request()->has('ability_id'))
                    <a href="{{ route('abilities.abilities', [$model, '#ability-abilities']) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants->count() }})
                    </a>
                @else
                    <a href="{{ route('abilities.abilities', [$model, 'ability_id' => $model->id, '#ability-abilities']) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->abilities->count() }})
                    </a>
                @endif
            </div>
        </div>

        <table id="abilities" class="table table-hover margin-top ">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('abilities.fields.name') }}</th>
                <th>{{ __('crud.fields.ability') }}</th>
                <th>{{ __('crud.fields.type') }}</th>
            </tr>
            @foreach ($r as $ability)
                <tr class="{{ $ability->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $ability->getImageUrl(40) }}');" title="{{ $ability->name }}" href="{{ route('abilities.show', $ability->id) }}"></a>
                    </td>
                    <td>
                        @if ($ability->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $ability->tooltipedLink() !!}
                    </td>
                    <td>
                        @if ($ability->parent)
                            {!! $ability->parent->tooltipedLink() !!}
                        @endif
                    </td>
                    <td>
                        @if ($ability->type)
                            {!! $ability->type !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->fragment('ability-abilities')->links() }}
        </div>
    @endif
</div>
