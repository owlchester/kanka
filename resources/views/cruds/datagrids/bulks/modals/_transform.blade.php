
<div class="modal-header">
    <x-dialog.close :modal="true" />
    <h4 class="modal-title" id="clickModalLabel">{{ __('entities/transform.panel.bulk_title') }}</h4>
</div>
<div class="modal-body">
    <p class="help-block">
        {{ __('entities/transform.panel.bulk_description') }}
    </p>

    <x-forms.field field="target" :label="__('entities/transform.fields.target')">
        {!! Form::select('target', $entities, null, ['class' => 'form-control']) !!}
    </x-forms.field>

    <x-dialog.footer :modal="true">
        <button class="btn2 btn-primary" type="submit">
            <i class="fa-solid fa-exchange-alt" aria-hidden="true"></i>
            {{ __('entities/transform.actions.transform') }}
        </button>
    </x-dialog.footer>
</div>

<input type="hidden" name="datagrid-action" value="transform" />
