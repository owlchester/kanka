{!! Form::open([
    'route' => ['characters.character_organisations.store', $model->id],
    'method'=>'POST',
    'data-shortcut' => '1'
]) !!}

@if (request()->ajax())
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
        <h4>{{ __('characters.organisations.create.title', ['name' => $model->name]) }}</h4>
    </div>
    <div class="modal-body">
        @include('characters.organisations._form')
    </div>
    <div class="modal-footer">
        <button class="btn btn-success">{{ __('crud.save') }}</button>
        <div class="pull-left">
            @include('partials.footer_cancel')
        </div>
    </div>
@else
    <div class="panel panel-default">
        <div class="panel-body">
            @include('characters.organisations._form')
        </div>
        <div class="panel-footer">
            <button class="btn btn-success pull-right">{{ __('crud.save') }}</button>
            @include('partials.footer_cancel')
        </div>
    </div>
@endif

{!! Form::hidden('character_id', $model->id) !!}
{!! Form::close() !!}
