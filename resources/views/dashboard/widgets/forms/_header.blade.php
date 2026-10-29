@php
    $target = isset($model) ? $model->target : null;
    $targetType = old('target_type', $target instanceof \App\Models\CampaignDashboard ? 'dashboard' : ($target instanceof \App\Models\Entity ? 'entity' : ''));
@endphp

<x-grid :xdata="'{ targetType: ' . json_encode($targetType) . ' }'">
    @include('dashboard.widgets.forms._name')

    @include('dashboard.widgets.forms._size')

    <x-forms.field field="target_type" :label="__('dashboard.widgets.fields.link')">
        <select name="target_type" x-model="targetType" class="w-full">
            <option value="">{{ __('dashboard.widgets.fields.no-link') }}</option>
            <option value="entity">{{ __('dashboard.widgets.fields.optional-entity') }}</option>
            <option value="dashboard" @disabled(!$premium && !($target instanceof \App\Models\CampaignDashboard))>{{ __('dashboard.widgets.fields.dashboard-link') }}</option>
        </select>
    </x-forms.field>
    <div x-show="targetType === 'entity'" x-cloak>
        @include('cruds.fields.entity', [
            'label' => __('dashboard.widgets.fields.optional-entity'),
            'preset' => $target instanceof \App\Models\Entity ? $target : null,
        ])
    </div>
    <x-forms.field field="target_dashboard_id" :label="__('dashboard.widgets.fields.dashboard-link')" x-show="targetType === 'dashboard'" x-cloak>
        <select name="target_dashboard_id" class="w-full">
            @if ($target instanceof \App\Models\CampaignDashboard && !isset($dashboards[$target->id]))
                <option value="{{ $target->id }}" selected>{{ $target->name }}</option>
            @endif
            @foreach ($dashboards as $id => $name)
                <option value="{{ $id }}" @selected((string) old('target_dashboard_id', $target instanceof \App\Models\CampaignDashboard ? $target->id : '') === (string) $id)>{{ $name }}</option>
            @endforeach
        </select>
        @if (!$premium && $target instanceof \App\Models\CampaignDashboard)
            <p class="text-xs text-neutral-content mt-1">{{ __('dashboard.widgets.helpers.premium-dashboard-target') }}</p>
        @endif
    </x-forms.field>

    @include('dashboard.widgets.forms._width')
</x-grid>

<x-widgets.forms.advanced>
    @include('dashboard.widgets.forms._class')
</x-widgets.forms.advanced>
