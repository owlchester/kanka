{!! Form::open([
    'url' => route('bulk.transform.apply', [$campaign, $entityType]),
    'method' => 'POST'
]) !!}
@include('partials.forms.form', [
    'title' => __('entities/transform.panel.bulk_title'),
    'content' => 'cruds.datagrids.bulks.modals.forms._transform',
    'submit' => __('entities/transform.actions.transform'),
    'dialog' => true,
])
<input type="hidden" name="models" />
{!! Form::close() !!}
