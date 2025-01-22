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

        <x-grid>
            <x-forms.field
                field="privacy"
                :label="__('campaigns.fields.entity_privacy')"
                :helper="__('campaigns.helpers.entity_privacy')">
                <x-forms.select name="entity_visibility" :options="[0 => __('campaigns.privacy.visible'), 1 => __('campaigns.privacy.private')]" :selected="$campaign->entity_visibility ?? null" />
            </x-forms.field>

            <x-forms.field
                field="related-visibility"
                :label="__('campaigns.fields.related_visibility')"
                :helper="__('campaigns.helpers.related_visibility')">
                <x-forms.select name="settings[default_visibility]" :options="$visibilities" :selected="$campaign->settings['default_visibility'] ?? null" />
            </x-forms.field>

            <x-forms.field
                field="character_personality_visibility"
                :label="__('campaigns.fields.character_personality_visibility')"
                :helper="__('campaigns.helpers.character_personality_visibility')">
                <x-forms.select name="entity_personality_visibility" :options="[0 => __('campaigns.privacy.visible'), 1 => __('campaigns.privacy.private')]" :selected="$campaign->entity_personality_visibility ?? null" />
            </x-forms.field>

            <x-forms.field
                field="gallery-visibility"
                :label="__('campaigns.fields.gallery_visibility')"
                :helper="__('campaigns.helpers.gallery_visibility')">
                <x-forms.select name="settings[gallery_visibility]" :options="$visibilities" :selected="$campaign->settings['gallery_visibility'] ?? null" />
            </x-forms.field>

            <x-forms.field
                field="private_mention_visibility"
                :label="__('campaigns.fields.private_mention_visibility')"
                :helper="__('campaigns.helpers.private_mention_visibility')">
                <x-forms.select name="settings[private_mention_visibility]" :options="[0 => __('campaigns.privacy.private'), 1 => __('campaigns.privacy.visible')]" :selected="$campaign->settings['private_mention_visibility'] ?? null" />
            </x-forms.field>
        </x-grid>
    </x-grid>
</div>
