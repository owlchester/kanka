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

    <x-grid type="1/1">
        <x-helper :text="__('campaigns.helpers.permissions_tab')" />

        <x-grid type="3/3">
            <x-forms.field
                field="privacy"
                :label="__('campaigns.fields.entity_privacy')"
                :helper="__('campaigns.helpers.entity_privacy')">
                {!! Form::select('entity_visibility', [0 => __('campaigns.privacy.visible'), 1 => __('campaigns.privacy.private')], null, ['class' => '']) !!}
            </x-forms.field>

            <x-forms.field
                field="related-visibility"
                :label="__('campaigns.fields.related_visibility')"
                :helper="__('campaigns.helpers.related_visibility')">
                    {!! Form::select('settings[default_visibility]', $visibilities, null, ['class' => '']) !!}
            </x-forms.field>

            <x-forms.field
                field="character_personality_visibility"
                :label="__('campaigns.fields.character_personality_visibility')"
                :helper="__('campaigns.helpers.character_personality_visibility')">
                {!! Form::select('entity_personality_visibility', [0 => __('campaigns.privacy.visible'), 1 => __('campaigns.privacy.private')], null, ['class' => '']) !!}
            </x-forms.field>
        </x-grid>
    </x-grid>
</div>
