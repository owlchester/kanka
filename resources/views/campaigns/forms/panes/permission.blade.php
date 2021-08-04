<?php
$visibilities = [
    '' => __('crud.visibilities.all'),
    'admin' => __('crud.visibilities.admin'),
    'members' => __('crud.visibilities.members'),
    'self' => __('crud.visibilities.self'),
    'admin-self' => __('crud.visibilities.admin-self')
];
?>

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
                <label>{{ __('campaigns.fields.related_visibility') }}</label>
                    {!! Form::select('settings[default_visibility]', $visibilities, null, ['class' => 'form-control']) !!}
                <p class="help-block">{{ __('campaigns.helpers.related_visibility') }}</p>
            </div>
        </div>
    </div>
</div>
