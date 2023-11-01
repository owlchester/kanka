<form method="POST" action="{{ $route }}">
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
