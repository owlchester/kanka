<div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
    <div class="form-group required">
        <label>
            {{ __('campaigns.fields.name') }}
            <i class="fas fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('campaigns.helpers.name') }}"></i>
        </label>
        {!! Form::text('name', null, ['placeholder' => __('campaigns.placeholders.name'), 'class' => 'form-control', 'required', 'maxlength' => 191]) !!}
        <p class="help-block visible-xs visible-sm">{{ __('campaigns.helpers.name') }}</p>
    </div>

    <div class="form-group">
        <label>{{ __('campaigns.fields.description') }}</label>
        {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
    </div>

    @include('cruds.fields.image')
</div>
