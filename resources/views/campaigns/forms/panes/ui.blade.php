@php
/** @var \App\Models\Campaign $model */
$themes = [null => __('campaigns.themes.none')];
foreach (\App\Models\Theme::all() as $theme):
    $themes[$theme->id] = $theme->__toString();
endforeach;

$role = isset($model) ? $model->adminRole() : null;
$boostedFormFields = [
    'class' => 'w-full',
];
if (!isset($model) || !$model->boosted()) {
    $boostedFormFields['disabled'] = 'disabled';
}
@endphp

<div class="tab-pane" id="form-ui">
    <x-grid type="1/1">
        <h4>
            {{ ucfirst(__('concept.premium-campaign')) }}
        </h4>
        @if (isset($model) && $model->boosted())
            <x-helper>
                <p>{!! __('campaigns.helpers.premium', ['settings' => '<a href="https://kanka.io/premium">' . __('concept.premium-campaigns') . '</a>']) !!}</p>
            </x-helper>
        @else
            <x-helper>
                <p>{!! __('campaigns.helpers.premium', ['settings' => '<a href="https://kanka.io/premium">' . __('concept.premium-campaigns') . '</a>']) !!}</p>
            </x-helper>
        @endif

        <x-grid>
            <x-forms.field
                field="theme"
                :label="__('campaigns.fields.theme')"
                :helper="__('campaigns.ui.helpers.theme')"
                >
                @php $dizzy = [];
                if (!isset($campaign) || !$campaign->boosted()) {
                    foreach ($themes as $i => $n) {
                        if (empty($i)) continue;
                        $dizzy[$i] = ['disabled' => true];
                    }
                }
                @endphp
                <x-forms.select name="theme_id" :options="$themes" :selected="$campaign->theme_id ?? null" :optionAttributes="$dizzy" />
            </x-forms.field>

            <x-forms.field
                field="member-list"
                :label="__('campaigns.ui.fields.member_list')"
                :helper="__('campaigns.ui.helpers.member-list')"
                >
                @php $dizzy = [];
                if (!isset($campaign) || !$campaign->boosted()) {
                    $dizzy = [1 => ['disabled' => true]];
                }
                @endphp
                <x-forms.select name="ui_settings[hide_members]" :options="[0 => __('campaigns.ui.members.visible'), 1 => __('campaigns.ui.members.hidden')]" :selected="$campaign->ui_settings['hide_members'] ?? null" :optionAttributes="$dizzy" />
                @if (!isset($model) || !$model->boosted())
                    <input type="hidden" name="ui_settings[hide_members]" value="0" />
                @endif
            </x-forms.field>

            <x-forms.field
                field="entity-history"
                :label="__('campaigns.ui.fields.entity_history')"
                :helper="__('campaigns.ui.helpers.entity-history')"
                >
                @php $dizzy = [];
                if (!isset($campaign) || !$campaign->boosted()) {
                    $dizzy = [1 => ['disabled' => true]];
                }
                @endphp
                <x-forms.select name="ui_settings[hide_history]" :options="[0 => __('campaigns.ui.entity_history.visible'), 1 => __('campaigns.ui.entity_history.hidden')]" :selected="$campaign->ui_settings['hide_history'] ?? null" :optionAttributes="$dizzy" />
                @if (!isset($model) || !$model->boosted())
                    <input type="hidden" name="ui_settings[hide_history]" value="0" />
                @endif
            </x-forms.field>
        </x-grid>

        <hr />

        <h4>{{ __('campaigns.ui.other') }}</h4>
        <x-helper>
            <p>{{  __('campaigns.ui.helpers.other') }}</p>
        </x-helper>

        <x-grid>
            <x-forms.field
                field="connections"
                :label="__('campaigns.ui.fields.connections')"
                :helper="__('campaigns.ui.helpers.connections')"
                >
                <x-forms.select name="ui_settings[connections]" :options="[0 => __('campaigns.ui.connections.explorer'), 1 => __('campaigns.ui.connections.list')]" :selected="$campaign->ui_settings['connections'] ?? null"  />
            </x-forms.field>

            <x-forms.field
                field="connections-mode"
                :label="__('campaigns.ui.fields.connections_mode')"
                :helper="__('campaigns.ui.helpers.connections_mode')"
                >
                <x-forms.select name="ui_settings[connections_mode]" :options="[0 => __('campaigns.ui.collapsed.default'), 1 => __('entities/relations.options.only_relations'), 2 => __('entities/relations.options.related'), 3 => __('entities/relations.options.mentions')]" :selected="$campaign->ui_settings['connections_mode'] ?? null"  />
            </x-forms.field>

            <x-forms.field
                field="post-collapsed"
                :label="__('campaigns.ui.fields.post_collapsed')"
                :helper="__('campaigns.ui.helpers.post_collapsed')"
                >
                <x-forms.select name="ui_settings[post_collapsed]" :options="[0 => __('campaigns.ui.collapsed.default'), 1 => __('campaigns.ui.collapsed.collapsed')]" :selected="$campaign->ui_settings['post_collapsed'] ?? null"  />
            </x-forms.field>

            <x-forms.field
                field="descendants"
                :label="__('campaigns.ui.fields.descendants')"
                :helper="__('campaigns.ui.helpers.descendants')"
                >
                <x-forms.select name="ui_settings[descendants]" :options="[0 => __('campaigns.ui.descendants.direct'), 1 => __('campaigns.ui.descendants.all')]" :selected="$campaign->ui_settings['descendants'] ?? null"  />
            </x-forms.field>
        </x-grid>
    </x-grid>
</div>
