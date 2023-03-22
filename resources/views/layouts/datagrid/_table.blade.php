@if (!empty($datagridUrl))
    <div class="box-body text-center datagrid-onload" href="{{ $datagridUrl }}">
        <table class="table table-hover" data-render="datagrid2"></table>
        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
    </div>
<?php return; ?>
@endif

<div class="box-body no-padding">
    <table class="table table-hover mb-0" data-render="datagrid2">
        <thead>
            <tr>
                @foreach (Datagrid::headers() as $header)
                    @include('layouts.datagrid._header')
                @endforeach
            </tr>
        </thead>
        <tbody>
        @forelse ($rows as $row)
            @if ($row instanceof \App\Models\MiscModel && empty($row->entity))
                @continue
            @endif
            <tr class="{{ method_exists($row, 'rowClasses') ? $row->rowClasses() : null }} @if (Datagrid::isHighlighted($row)) warning row-highlighted @endif">
                @foreach (Datagrid::columns($row) as $column)
                    @include('layouts.datagrid._column')
                @endforeach
            </tr>
        @empty
            <tr>
                <td colspan="{{ count(Datagrid::headers()) }}">
                    <i>{{ __('crud.datagrid.empty') }}</i>
                </td>
            </tr>
        @endforelse
        </tbody>
        <tfoot style="display: none">
        <tr>
            <th class="text-center">
                <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
            </th>
        </tr>
        </tfoot>
    </table>
</div>
@if ($rows->hasPages() || Datagrid::hasBulks() )
    <div class="box-footer text-right clearfix">
        <div class="pull-left">
            @includeWhen(Datagrid::hasBulks(), 'layouts.datagrid.bulks')
        </div>
        {!! $rows->appends(Datagrid::paginationFilters())->links() !!}
    </div>
@endif
