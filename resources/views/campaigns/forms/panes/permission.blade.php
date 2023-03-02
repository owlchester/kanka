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

    <p class="help-block">
        {{ __('campaigns.helpers.permissions_tab') }}
    </p>
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label>
                    {{ __('campaigns.fields.entity_privacy') }}
                </label>
                {!! Form::select('entity_visibility', [0 => __('campaigns.privacy.visible'), 1 => __('campaigns.privacy.private')], null, ['class' => 'form-control']) !!}
                <p class="help-block">{{ __('campaigns.helpers.entity_privacy') }}</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label>
                    {{ __('campaigns.fields.related_visibility') }}
                </label>
                    {!! Form::select('settings[default_visibility]', $visibilities, null, ['class' => 'form-control']) !!}
                <p class="help-block">{{ __('campaigns.helpers.related_visibility') }}</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="form-group">
                <label>
                    {{ __('campaigns.fields.character_personality_visibility') }}
                </label>
                {!! Form::select('entity_personality_visibility', [0 => __('campaigns.privacy.visible'), 1 => __('campaigns.privacy.private')], null, ['class' => 'form-control']) !!}
                <p class="help-block">{{ __('campaigns.helpers.character_personality_visibility') }}</p>
            </div>
        </div>
    </div>
</div>
