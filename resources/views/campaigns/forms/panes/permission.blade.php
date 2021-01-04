<div class="tab-pane" id="form-permission">
    <div class="row">
        <div class="col-md-6">
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
        </div>

        <div class="col-md-6">
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

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::hidden('settings[entity_note_visibility]', 0) !!}
                <label>{{ __('campaigns.fields.entity_note_visibility') }}</label>
                <div class="checkbox">
                    <label>{!! Form::checkbox('settings[entity_note_visibility]') !!}
                        {{ __('campaigns.entity_note_visibility.pinned') }}
                    </label>
                </div>
                <p class="help-block">{{ __('campaigns.helpers.entity_note_visibility') }}</p>
            </div>
        </div>
    </div>
</div>
