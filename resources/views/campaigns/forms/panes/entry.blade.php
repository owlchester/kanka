<div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
    <div class="form-group required">
        <label>{{ __('campaigns.fields.name') }}</label>
        {!! Form::text('name', null, ['placeholder' => __('campaigns.placeholders.name'), 'class' => 'form-control', 'required']) !!}
        <p class="help-block">{{ __('campaigns.helpers.name') }}</p>
    </div>

    <div class="form-group">
        <label>{{ __('campaigns.fields.description') }}</label>
        {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
    </div>

    @include('cruds.fields.image')
</div>