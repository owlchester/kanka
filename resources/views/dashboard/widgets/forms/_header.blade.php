@php $boosted = $campaign->boosted() @endphp

<x-grid>
    @include('dashboard.widgets.forms._name')

    @include('dashboard.widgets.forms._size')

    @include('cruds.fields.entity', ['label' => __('dashboard.widgets.fields.optional-entity')])
    
    @include('dashboard.widgets.forms._width')
</x-grid>


<x-widgets.forms.advanced>
    @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')
    @include('dashboard.widgets.forms._class')
</x-widgets.forms.advanced>


