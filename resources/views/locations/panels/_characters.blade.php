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
            <tr class="{{ $row->rowClasses() }}">
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
