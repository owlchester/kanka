{!! Form::open([
    'route' => ['characters.character_organisations.store', $model->id],
    'method'=>'POST',
    'data-shortcut' => '1'
]) !!}

@include('partials.forms.form', [
    'title' => __('characters.organisations.create.title', ['name' => $model->name]),
    'content' => 'characters.organisations._form',
])

{!! Form::hidden('character_id', $model->id) !!}
{!! Form::close() !!}
