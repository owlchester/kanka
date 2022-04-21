@if (empty($rows) && isset($empty))
    <div class="box-body">
        <p class="help-block">
            {!! $empty !!}
        </p>
    </div>
    @php return @endphp
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
            <tr>
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
@if ($rows->hasPages() || \App\Facades\Datagrid::hasBulks())
    <div class="box-footer text-right">
        <div class="pull-left">
            @includeWhen(Datagrid::hasBulks(), 'layouts.datagrid.bulks')
        </div>
        {!! $rows->appends(Datagrid::paginationFilters())->links() !!}
    </div>
@endif
