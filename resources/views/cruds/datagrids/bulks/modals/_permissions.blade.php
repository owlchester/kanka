{!! Form::open([
    'url' => route('bulk.permissions.apply', [$campaign, $entityType]),
    'method' => 'POST'
]) !!}
@include('partials.forms.form', [
    'title' => __('crud.bulk.permissions.title'),
    'content' => 'cruds.datagrids.bulks.modals.forms._permissions',
    'submit' => __('crud.bulk.actions.permissions'),
    'dialog' => true,
])
<input type="hidden" name="models" />
{!! Form::close() !!}
