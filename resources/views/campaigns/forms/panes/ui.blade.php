@php
/** @var \App\Models\Campaign $model */
$themes = [null => __('campaigns.themes.none')];
foreach (\App\Models\Theme::all() as $theme):
    $themes[$theme->id] = $theme->__toString();
endforeach;

$role = isset($model) ? \App\Facades\CampaignCache::adminRole() : null;
$boostedFormFields = [
    'class' => 'w-full',
];
if (!isset($model) || !$model->boosted()) {
    $boostedFormFields['disabled'] = 'disabled';
}
@endphp

<div class="tab-pane" id="form-ui">

    <h4>
        {{ ucfirst(__('concept.premium-campaign')) }}
    </h4>
    @if (isset($model) && $model->boosted())
        <x-helper>
            {!! __('campaigns.helpers.premium', ['settings' => link_to('https://kanka.io/premium', __('concept.premium-campaigns'))]) !!}
        </x-helper>
    @else
        <x-helper>
            {!! __('campaigns.helpers.premium', ['settings' => link_to('https://kanka.io/premium', __('concept.premium-campaigns'))]) !!}
        </x-helper>
    @endif

    <x-grid type="3/3">
        <x-forms.field
            field="theme"
            :label="__('campaigns.fields.theme')"
            :helper="__('campaigns.ui.helpers.theme')">
            {!! Form::select(
                'theme_id',
                $themes,
                null,
                $boostedFormFields
            ) !!}
        </x-forms.field>

        <x-forms.field
            field="member-list"
            :label="__('campaigns.ui.fields.member_list')"
            :helper="__('campaigns.ui.helpers.member-list')">
            {!! Form::select('ui_settings[hide_members]', [0 => __('campaigns.ui.members.visible'), 1 => __('campaigns.ui.members.hidden')], null, $boostedFormFields) !!}
            @if (!isset($model) || !$model->boosted())
                {!! Form::hidden('ui_settings[hide_members]', 0) !!}
            @endif
        </x-forms.field>

        <x-forms.field
            field="entity-history"
            :label="__('campaigns.ui.fields.entity_history')"
            :helper="__('campaigns.ui.helpers.entity-history')">
            {!! Form::select('ui_settings[hide_history]', [0 => __('campaigns.ui.entity_history.visible'), 1 => __('campaigns.ui.entity_history.hidden')], null, $boostedFormFields) !!}
            @if (!isset($model) || !$model->boosted())
                {!! Form::hidden('ui_settings[hide_history]', 0) !!}
            @endif
        </x-forms.field>
    </x-grid>

    <hr />

    <h4>{{ __('crud.fields.tooltip') }}</h4>
    <x-helper :text="__('campaigns.ui.helpers.tooltip')" />

    <x-grid type="3/3">
        <x-forms.field
            field="entity-image"
            :label="__('campaigns.ui.fields.entity_image')">
            {!! Form::select('ui_settings[tooltip_image]', [0 => __('campaigns.privacy.hidden'), 1 => __('campaigns.privacy.visible')], null, $boostedFormFields) !!}
            @if (!isset($model) || !$model->boosted())
                {!! Form::hidden('ui_settings[tooltip_image]', 0) !!}
                <x-helper :text="__('callouts.premium.limitation')" />
            @endif
        </x-forms.field>
    </x-grid>

    <hr />

    <h4>{{ __('campaigns.ui.other') }}</h4>
    <x-helper :text="__('campaigns.ui.helpers.other')" />

    <x-grid type="3/3">
        <x-forms.field
            field="connections"
            :label="__('campaigns.ui.fields.connections')"
            :helper="__('campaigns.ui.helpers.connections')"
            :tooltip="true">
            {!! Form::select('ui_settings[connections]', [0 => __('campaigns.ui.connections.explorer'), 1 => __('campaigns.ui.connections.list')], null, ['class' => 'w-full']) !!}
        </x-forms.field>

        <x-forms.field
            field="connections-mode"
            :label="__('campaigns.ui.fields.connections_mode')"
            :helper="__('campaigns.ui.helpers.connections_mode')"
            :tooltip="true">
            {!! Form::select('ui_settings[connections_mode]', [0 => __('campaigns.ui.collapsed.default'), 1 => __('entities/relations.options.only_relations'), 2 => __('entities/relations.options.related'), 3 => __('entities/relations.options.mentions')], null, ['class' => 'w-full']) !!}
        </x-forms.field>

        <x-forms.field
            field="nested"
            :label="__('campaigns.ui.fields.nested')">
            {!! Form::select('ui_settings[nested]', [0 => __('campaigns.ui.nested.user'), 1 => __('campaigns.ui.nested.nested')], (!isset($model) ? 1 : null), ['class' => '']) !!}
        </x-forms.field>

        <x-forms.field
            field="post-collapsed"
            :label="__('campaigns.ui.fields.post_collapsed')"
            :helper="__('campaigns.ui.helpers.post_collapsed')"
            :tooltip="true">
            {!! Form::select('ui_settings[post_collapsed]', [0 => __('campaigns.ui.collapsed.default'), 1 => __('campaigns.ui.collapsed.collapsed')], null, ['class' => 'w-full']) !!}
        </x-forms.field>
    </x-grid>
</div>
