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
        @foreach ($styles as $style)
            <tr>
                @foreach (Datagrid::columns($style) as $column)
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
</div>
@if (Datagrid::hasBulks())
    <div class="box-footer text-right">
        <div class="pull-left">
            @includeWhen(Datagrid::hasBulks(), 'layouts.datagrid.bulks')
        </div>
    </div>
@endif
