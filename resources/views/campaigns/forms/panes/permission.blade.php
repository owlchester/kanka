<div class="tab-pane" id="form-permission">
    <div class="form-group">
        {!! Form::hidden('entity_visibility', 0) !!}
        <label>{{ __('campaigns.fields.entity_visibility') }}</label>
        <div class="checkbox">
            <label>{!! Form::checkbox('entity_visibility') !!}
                {{ __('campaigns.entity_visibilities.private') }}
            </label>
        </div>
        <p class="help-block">{{ __('campaigns.helpers.entity_visibility') }}</p>
    </div>
    <div class="form-group">
        {!! Form::hidden('entity_personality_visibility', 0) !!}
        <label>{{ __('campaigns.fields.entity_personality_visibility') }}</label>
        <div class="checkbox">
            <label>{!! Form::checkbox('entity_personality_visibility') !!}
                {{ __('campaigns.entity_personality_visibilities.private') }}
            </label>
        </div>
        <p class="help-block">{{ __('campaigns.helpers.entity_personality_visibility') }}</p>
    </div>
</div>