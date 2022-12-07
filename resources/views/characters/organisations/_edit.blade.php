{!! Form::model($member, [
    'method' => 'PATCH',
    'route' => ['characters.character_organisations.update', $model->id, $member->id],
    'data-shortcut' => 1
]) !!}

@include('partials.forms.form', [
    'title' => __('characters.organisations.edit.title', ['name' => $model->name]),
    'content' => 'characters.organisations._form',
])

{!! Form::hidden('character_id', $model->id) !!}
@if (request()->has('from'))
    <input type="hidden" name="from" value="{{ request()->get('from') }}" />
@endif
{!! Form::close() !!}
