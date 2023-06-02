@if (!empty($datagridUrl))
    <div class="box-body text-center datagrid-onload" href="{{ $datagridUrl }}">
        <table class="table table-hover" data-render="datagrid2"></table>
        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
    </div>
<?php return; ?>
@endif

@if (isset($responsive))<div class="table-responsive">@endif
<table class="table table-hover mb-0 w-full shadow-xs bg-box mb-2 rounded" data-render="datagrid2">
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
            <td colspan="{{ count(Datagrid::headers()) }}" class="!align-middle">
                <i>{{ __('crud.datagrid.empty') }}</i>
            </td>
        </tr>
    @endforelse
    </tbody>
    <tfoot style="display: none">
    <tr>
        <th class="text-center">
            <i class="fa-solid fa-spinner fa-spin fa-2x" aria-hidden="true"></i>
        </th>
    </tr>
    </tfoot>
</table>

@if (isset($responsive))</div>@endif
@if ($rows->hasPages() || Datagrid::hasBulks() )
    <div class="text-right clearfix">
        <div class="pull-left">
            @includeWhen(Datagrid::hasBulks(), 'layouts.datagrid.bulks')
        </div>
        {!! $rows->appends(Datagrid::paginationFilters())->links() !!}
    </div>
@endif
