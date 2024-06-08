<form method="POST" action="{{ $route }}" data-shortcut="1" class="w-full ajax-submit datagrid2-bulk-update">
    @csrf
    @include('partials.forms.form', [
        'title' => __('crud.bulk.edit.title'),
        'content' => 'layouts.datagrid.bulks.' . $view,
        'submit' => __('crud.actions.apply'),
        'dialog' => true,
    ])

@foreach ($models as $model)
    <input type="hidden" name="model[]" value="{{ $model }}" />
@endforeach
<input type="hidden" name="action" value="patch" />
</form>
