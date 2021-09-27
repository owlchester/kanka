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
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('entity_visibility') !!}
                        {{ __('campaigns.options.entity_visibility') }}
                    </label>
                </div>
            </div>

            <div class="form-group">
                {!! Form::hidden('entity_personality_visibility', 0) !!}
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('entity_personality_visibility') !!}
                        {{ __('campaigns.options.entity_personality_visibility') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>
                    {{ __('campaigns.fields.related_visibility') }}
                    <i class="fas fa-question-circle hidden-xs hidden-sm" data-toggle="tooltip" title="{{ __('campaigns.helpers.related_visibility') }}"></i>
                </label>
                    {!! Form::select('settings[default_visibility]', $visibilities, null, ['class' => 'form-control']) !!}
                <p class="help-block visible-xs visible-sm">{{ __('campaigns.helpers.related_visibility') }}</p>
            </div>
        </div>
    </div>
</div>
