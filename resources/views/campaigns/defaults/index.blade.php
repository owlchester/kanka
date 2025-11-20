<?php
/** @var \App\Models\Campaign $campaign */
$visibilities = [
    '' => __('crud.visibilities.all'),
    'admin' => __('crud.visibilities.admin'),
    'members' => __('crud.visibilities.members'),
    'self' => __('crud.visibilities.self'),
    'admin-self' => __('crud.visibilities.admin-self')
];
?>
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.defaults') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.defaults')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')

    <x-form :action="['campaign-defaults-save', $campaign]" class="defaults-form form-inline">
        <div class="flex gap-5 flex-col">
            @include('partials.errors')

            <div class="flex gap-2 items-center">
                <h3 class="inline-block grow">
                    {{ __('campaigns.show.tabs.defaults') }}
                </h3>

                <x-learn-more url="features/campaigns/defaults.html" />
            </div>

            <p>
                {!! __('campaigns/defaults.tutorial') !!}
            </p>

            <h4>{{ __('campaigns/defaults.sections.entity') }}</h4>
            <x-box>
                <x-grid type="1/1">

                    <x-helper>
                        <p>{{  __('campaigns/defaults.helpers.entity') }}</p>
                    </x-helper>

                    <x-forms.field
                        field="privacy"
                        :label="__('campaigns/defaults.fields.entity_privacy')"
                        :helper="__('campaigns/defaults.helpers.entity_privacy')">
                        <x-forms.select name="entity_visibility" :options="[0 => __('campaigns.privacy.visible'), 1 => __('campaigns.privacy.private')]" :selected="$campaign->entity_visibility ?? null" />
                    </x-forms.field>

                    <x-forms.field
                        field="related-visibility"
                        :label="__('campaigns/defaults.fields.related_visibility')"
                        :helper="__('campaigns/defaults.helpers.related_visibility')">
                        <x-forms.select name="settings[default_visibility]" :options="$visibilities" :selected="$campaign->settings['default_visibility'] ?? null" />
                    </x-forms.field>

                    <x-forms.field
                        field="character_personality_visibility"
                        :label="__('campaigns/defaults.fields.character_personality_visibility')"
                        :helper="__('campaigns/defaults.helpers.character_visibility')">
                        <x-forms.select name="entity_personality_visibility" :options="[0 => __('campaigns.privacy.visible'), 1 => __('campaigns.privacy.private')]" :selected="$campaign->entity_personality_visibility ?? null" />
                    </x-forms.field>
                </x-grid>
            </x-box>

            <h4>{{ __('campaigns/defaults.sections.media') }}</h4>
            <x-box>
                <x-forms.field
                    field="gallery-visibility"
                    :label="__('campaigns/defaults.fields.gallery_visibility')"
                    :helper="__('campaigns/defaults.helpers.gallery_visibility')">
                    <x-forms.select name="settings[gallery_visibility]" :options="$visibilities" :selected="$campaign->settings['gallery_visibility'] ?? null" />
                </x-forms.field>
            </x-box>

            <h4>{{ __('campaigns/defaults.sections.mention') }}</h4>
            <x-box>
                <x-forms.field
                    field="private_mention_visibility"
                    :label="__('campaigns/defaults.fields.private_mention_visibility')"
                    :helper="__('campaigns/defaults.helpers.private_mention_visibility')">
                    <x-forms.select name="settings[private_mention_visibility]" :options="[0 => __('campaigns/defaults.values.mentions.private'), 1 => __('campaigns/defaults.values.mentions.visible')]" :selected="$campaign->settings['private_mention_visibility'] ?? null" />
                </x-forms.field>
            </x-box>


            <h4>{{ __('campaigns/defaults.sections.display') }}</h4>
            <x-box>
                <x-grid type="1/1">
                    <x-helper>
                        <p>{{  __('campaigns/defaults.helpers.display') }}</p>
                    </x-helper>

                    <x-forms.field
                        field="connections"
                        :label="__('campaigns/defaults.fields.connections')"
                        :helper="__('campaigns/defaults.helpers.connections')"
                    >
                        <x-forms.select name="ui_settings[connections]" :options="[0 => __('campaigns/defaults.values.connections.explorer'), 1 => __('campaigns/defaults.values.connections.list')]" :selected="$campaign->ui_settings['connections'] ?? null"  />
                    </x-forms.field>

                    <x-forms.field
                        field="connections-mode"
                        :label="__('campaigns/defaults.fields.connections_mode')"
                        :helper="__('campaigns/defaults.helpers.connections_mode')"
                    >
                        <x-forms.select name="ui_settings[connections_mode]" :options="[0 => __('campaigns/defaults.values.collapsed.default'), 1 => __('entities/relations.options.only_relations'), 2 => __('entities/relations.options.related'), 3 => __('entities/relations.options.mentions')]" :selected="$campaign->ui_settings['connections_mode'] ?? null"  />
                    </x-forms.field>

                    <x-forms.field
                        field="post-collapsed"
                        :label="__('campaigns/defaults.fields.post_collapsed')"
                        :helper="__('campaigns/defaults.helpers.post_collapsed')"
                    >
                        <x-forms.select name="ui_settings[post_collapsed]" :options="[0 => __('campaigns/defaults.values.collapsed.expanded'), 1 => __('campaigns/defaults.values.collapsed.collapsed')]" :selected="$campaign->ui_settings['post_collapsed'] ?? null"  />
                    </x-forms.field>

                    <x-forms.field
                        field="descendants"
                        :label="__('campaigns/defaults.fields.descendants')"
                        :helper="__('campaigns/defaults.helpers.descendants')"
                    >
                        <x-forms.select name="ui_settings[descendants]" :options="[0 => __('campaigns/defaults.values.descendants.direct'), 1 => __('campaigns/defaults.values.descendants.all')]" :selected="$campaign->ui_settings['descendants'] ?? null"  />
                    </x-forms.field>
                </x-grid>
            </x-box>

            <div class="sticky bottom-4 ml-auto z-50">
                <button type="submit" class="btn2 btn-primary">
                    <x-icon class="save" />
                    {{ __('crud.save') }}
                </button>
            </div>
        </div>
    </x-form>

@endsection
