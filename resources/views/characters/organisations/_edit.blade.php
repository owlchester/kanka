{!! Form::model($member, [
    'method' => 'PATCH',
    'route' => ['characters.character_organisations.update', $model->id, $member->id],
    'data-shortcut' => 1
]) !!}

<div class="panel panel-default">
    @if ($ajax)
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
            <h4>{{ __('characters.organisations.edit.title', ['name' => $model->name]) }}</h4>
        </div>
    @endif
    <div class="panel-body">
        @include('partials.errors')

        @include('characters.organisations._form')
    </div>
    <div class="panel-footer">
        <button class="btn btn-success pull-right">{{ __('crud.save') }}</button>
        @include('partials.footer_cancel')
    </div>
</div>
{!! Form::hidden('character_id', $model->id) !!}
{!! Form::close() !!}
