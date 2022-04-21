@if ($header->bulk())
    <th>
        <input type="checkbox" name="all" id="datagrid-select-all" />
    </th>
@else
    <th class="{{ $header->css() }}">{!! $header !!}</th>
@endif
