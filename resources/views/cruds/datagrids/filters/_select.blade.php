<input type="hidden" name="{{ $field['id'] }}" value="" />
{!! Form::select(
    $field['field'],
    array_merge(['' => ''], $field['data']), // Add an empty option
    $value,
    [
        'id' => $field['field'],
        'class' => 'form-control select2 entity-list-filter',
    ]
) !!}
