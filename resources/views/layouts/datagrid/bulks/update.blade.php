<form method="POST" action="{{ $route }}" data-shortcut="1" class="w-full ajax-submit datagrid2-bulk-update">
    @csrf
    @include('partials.forms._dialog', [
        'title' => __('crud.bulk.edit.title'),
        'content' => 'layouts.datagrid.bulks.' . $view,
        'submit' => __('crud.actions.apply'),
    ])

@foreach ($models as $model)
    <input type="hidden" name="model[]" value="{{ $model }}" />
@endforeach
<input type="hidden" name="action" value="patch" />
</form>
