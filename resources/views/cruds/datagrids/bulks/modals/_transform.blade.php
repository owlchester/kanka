
<div class="modal-header">
    <x-dialog.close />
    <h4 class="modal-title" id="clickModalLabel">{{ __('entities/transform.panel.bulk_title') }}</h4>
</div>
<div class="modal-body">
    <p class="help-block">
        {{ __('entities/transform.panel.bulk_description') }}
    </p>

    <div class="form-group">
        <label>{{ __('entities/transform.fields.target') }}</label>
        {!! Form::select('target', $entities, null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="modal-footer">
    <a href="#" class="pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</a>
    <button class="btn btn-success" type="submit">
        <i class="fa-solid fa-exchange-alt" aria-hidden="true"></i>
        {{ __('entities/transform.actions.transform') }}
    </button>
</div>
<input type="hidden" name="datagrid-action" value="transform" />
