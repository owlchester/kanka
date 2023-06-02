@if (empty($rows) && isset($empty))
    <x-box>
        <p class="help-block">
            {!! $empty !!}
        </p>
    </x-box>
    @php return @endphp
@endif

<table class="table table-hover mb-2 bg-box" data-render="datagrid2">
    <thead>
    <tr>
        @foreach (Datagrid::headers() as $header)
            @include('layouts.datagrid._header')
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($rows as $row)
        <tr class="@if (Datagrid::isHighlighted($row)) warning row-highlighted @endif">
            @foreach (Datagrid::columns($row) as $column)
                @include('layouts.datagrid._column')
            @endforeach
        </tr>
    @endforeach
    </tbody>
    <tfoot style="display: none">
    <tr>
        <th class="text-center">
            <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
        </th>
    </tr>
    </tfoot>
</table>

@if ($rows->hasPages() || \App\Facades\Datagrid::hasBulks())
    <div class="text-right clearfix">
        <div class="pull-left">
            @includeWhen(Datagrid::hasBulks(), 'layouts.datagrid.bulks')
        </div>
        {!! $rows->appends(Datagrid::paginationFilters())->links() !!}
    </div>
@endif
