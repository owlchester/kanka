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
    </x-grid>
</div>
