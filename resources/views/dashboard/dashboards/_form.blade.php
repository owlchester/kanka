<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignDashboard $dashboard
 */
?>
<x-grid type="1/1">
    @empty($dashboard)
    <x-helper>
        {!! __('dashboard.dashboards.create.helper', ['name' => $campaign->name]) !!}
    </x-helper>
    @endif

    <x-forms.field
        field="name"
        required
        :label="__('dashboard.dashboards.fields.name')">

        <input type="text" name="name" placeholder="{{ __('dashboard.dashboards.placeholders.name') }}" maxlength="45" required value="{!! htmlspecialchars(old('name', $dashboard->name ?? null)) !!}" />
    </x-forms.field>

    <div class="field grid grid-cols-2 gap-2 items-center">
        <div class="font-extrabold">{{ __('campaigns.members.fields.role') }}</div>
        <div class="font-extrabold">{{ __('dashboard.dashboards.fields.visibility') }}</div>

        @foreach($campaign->roles as $role)
            <div class="truncate">
                <a href="{{ route('campaign_roles.show', [$campaign, $role]) }}">
                    {!! $role->name !!}
                </a>
            </div>
            <select name="roles[{{ $role->id }}]">
                @if(!$role->is_admin)
                <option value="">{{ __('dashboard.dashboards.visibility.none') }}</option>
                @endif

                <option value="visible" @if(!empty($dashboard) && $dashboard->permission($role)) selected="selected" @endif>{{ __('dashboard.dashboards.visibility.visible') }}</option>
                <option value="default" @if(!empty($dashboard) && $dashboard->permission($role, true)) selected="selected" @endif>{{ __('dashboard.dashboards.visibility.default') }}</option>
            </select>
        @endforeach
    </div>


    @if(!empty($source))
        <input type="hidden" name="copy_widgets" value="0" />
        <x-forms.field field="copy" :label="__('dashboard.dashboards.fields.copy_widgets')">
            <x-checkbox :text="__('dashboard.dashboards.helpers.copy_widgets', ['name' => $source->name])">
                <input type="checkbox" name="copy_widgets" value="1" @if (old('copy_widgets', true)) checked="checked" @endif />
            </x-checkbox>
            <input type="hidden" name="source" value="{{ $source->id }}" />
        </x-forms.field>
    @endif
</x-grid>
