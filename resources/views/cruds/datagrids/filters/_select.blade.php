<input type="hidden" name="{{ $field['id'] }}" value="" />
{!! Form::select(
    $field['field'],
    array_merge(['' => ''], $field['data']), // Add an empty option
    $value,
    [
        'id' => $field['field'],
        'class' => 'w-full select2 entity-list-filter',
        'data-dropdown-parent' => '#datagrid-filters'
    ]
) !!}
