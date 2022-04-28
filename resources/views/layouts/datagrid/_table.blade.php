@if (!empty($datagridUrl))
    <div class="box-body text-center datagrid-onload" href="{{ $datagridUrl }}">
        <table class="table table-hover" data-render="datagrid2"></table>
        <i class="fa fa-spinner fa-spin fa-2x"></i>
    </div>
<?php return; ?>
@endif
<div class="box-body no-padding">
    <table class="table table-hover" data-render="datagrid2">

        <thead>
        <tr>
            @foreach (Datagrid::headers() as $header)
                @include('layouts.datagrid._header')
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach ($rows as $row)
            <tr class="{{ method_exists($row, 'rowClasses') ? $row->rowClasses() : null }}">
                @foreach (Datagrid::columns($row) as $column)
                    @include('layouts.datagrid._column')
                @endforeach
            </tr>
        @endforeach
        </tbody>
        <tfoot style="display: none">
        <tr>
            <th class="text-center">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
            </th>
        </tr>
        </tfoot>
    </table>
</div>
@if ($rows->hasPages())
    <div class="box-footer text-right">
        {!! $rows->appends(Datagrid::paginationFilters())->links() !!}
    </div>
@endif
