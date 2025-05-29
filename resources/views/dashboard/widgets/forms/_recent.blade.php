@inject('entityTypeService', 'App\Services\EntityTypeService')
@php
    $advancedFilters = [
        '' => '',
        'unmentioned' => __('dashboard.widgets.recent.advanced_filters.unmentioned'),
        'mentionless' => __('dashboard.widgets.recent.advanced_filters.mentionless'),
    ];
    $boosted = $campaign->boosted();

    $entityTypes = $entityTypeService
        ->campaign($campaign)
        ->exclude([config('entities.ids.bookmark')])
        ->prepend(['' => __('dashboard.widgets.random.type.all')])
        ->toSelect();
@endphp

<x-grid>
    <x-forms.field field="entity-type" required :label="__('crud.fields.entity_type')">
        <x-forms.select name="entity_type_id" :options="$entityTypes" :selected="$model->entityType->id ?? null" class="w-full recent-entity-type" :extra="['data-animate' => 'reveal', 'data-target' => '.field-recent-filters']" />
    </x-forms.field>

    <x-forms.field
        field="recent-filters"
        :label="__('dashboard.widgets.recent.filters')"
        link="https://docs.kanka.io/en/latest/guides/dashboard.html"
        tooltip
        :helper="__('dashboard.widgets.helpers.filters')"
        :hidden="empty($model) || empty($model->entityType)">
        <input type="text" name="config[filters]" value="{{ old('config[filters]', $model->config['filters'] ?? null) }}" maxlength="191" class="w-full" id="config[filters]" placeholder="" />
    </x-forms.field>

    @include('dashboard.widgets.forms._tags')

    <x-forms.field field="advanced-filters" :label="__('dashboard.widgets.recent.advanced_filter')">
        <x-forms.select name="config[adv_filter]" :options="$advancedFilters" :selected="$model?->conf('adv_filter') ?? null" />
    </x-forms.field>

    <x-forms.field field="singular" css="col-span-2" :label="__('dashboard.widgets.recent.singular')">
        <input type="hidden" name="config[singular]" value="0" />
        <div class="checkbox" data-animate="collapse" data-target="#widget-advanced">
            <x-checkbox :text="__('dashboard.widgets.recent.help')">
                <input type="checkbox" name="config[singular]" value="1" @if (old('config[singular]', isset($model) ? $model->conf('singular') : false)) checked="checked" @endif />
            </x-checkbox>
        </div>
    </x-forms.field>

    <div class="col-span-2 hidden {{ isset($model) && $model->conf('singular') ? 'in' : null }}" id="widget-advanced">
        @if($campaign->boosted())
            @include('dashboard.widgets.forms._header_select')
            @include('dashboard.widgets.forms._related')
        @else
            <x-helper>
                <p>{!! __('dashboard.widgets.advanced_options_boosted', [
        'boosted_campaign' => '<a href="https://kanka.io/premium" target="_blank">' . __('concept.premium-campaigns') . '</a>']) !!}</p>
            </x-helper>
        @endif
    </div>
    @include('dashboard.widgets.forms._name')
    @include('dashboard.widgets.forms._width')

    <x-forms.field field="order" :label="__('dashboard.widgets.fields.order')">
        <x-forms.select name="config[order]" :options="['' => __('dashboard.widgets.orders.recent'),
    'oldest' => __('dashboard.widgets.orders.oldest'),
    'name_asc' => __('dashboard.widgets.orders.name_asc'),
    'name_desc' => __('dashboard.widgets.orders.name_desc')]" :selected="$model?->conf('order') ?? null" />
    </x-forms.field>

    @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')

</x-grid>

<x-widgets.forms.advanced>
    @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')
    @include('dashboard.widgets.forms._class')
</x-widgets.forms.advanced>
