<input type="hidden" name="{{ $field['id'] }}" value="" />
<x-forms.select
    :name="$field['field']"
    :options="array_merge(['' => ''], $field['data'])"
    :selected="$value"
    :id="$field['field']"
    class="select2 entity-list-filter"
    :extra="['data-dropdown-parent' => '#datagrid-filters']" />
