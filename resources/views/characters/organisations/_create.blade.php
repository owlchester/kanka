{!! Form::open([
    'route' => ['characters.character_organisations.store', $model->id],
    'method'=>'POST',
    'data-shortcut' => '1'
]) !!}

<div class="panel panel-default">
    @if ($ajax)
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
            <h4>{{ __('characters.organisations.create.title', ['name' => $model->name]) }}</h4>
        </div>
    @endif
    <div class="panel-body">
        @include('characters.organisations._form')
    </div>
    <div class="panel-footer">
        <button class="btn btn-success pull-right">{{ __('crud.save') }}</button>
        @include('partials.footer_cancel')
    </div>
</div>

{!! Form::hidden('character_id', $model->id) !!}
{!! Form::close() !!}
