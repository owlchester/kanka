@php $boosted = $campaign->boosted() @endphp

<x-grid type="1/1">
    @include('dashboard.widgets.forms._name')

    @include('dashboard.widgets.forms._width')

    @include('dashboard.widgets.forms._size')

    @include('cruds.fields.entity', ['label' => __('dashboard.widgets.fields.optional-entity')])
</x-grid>


<x-widgets.forms.advanced>
    @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')
    @include('dashboard.widgets.forms._class')
</x-widgets.forms.advanced>


