<div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
    <x-grid type="1/1">
        <div class="field-name required">
            <label>
                {{ __('campaigns.fields.name') }}
            </label>
            {!! Form::text('name', null, ['placeholder' => __('campaigns.placeholders.name'), 'class' => 'form-control', 'required', 'maxlength' => 191]) !!}
            <p class="help-block">{{ __('campaigns.helpers.name') }}</p>
        </div>

        <div class="field-entry">
            <label>{{ __('campaigns.fields.description') }}</label>
            {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
        </div>

        @include('cruds.fields.image', ['campaignImage' => true, 'imageLabel' => 'campaigns.fields.image'])
    </x-grid>
</div>
