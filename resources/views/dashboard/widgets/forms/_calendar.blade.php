@php $boosted = $campaign->boosted() @endphp
<x-grid type="1/1">
    <div class="col-span-2">
        @include('cruds.fields.entity', [
'required' => true, 'allowClear' => false, 'allowNew' => false,
'route' => 'search.calendars'])
    </div>
    @include('dashboard.widgets.forms._name')

    @include('dashboard.widgets.forms._width')

    @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
</x-grid>

<x-widgets.forms.advanced>
    @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')
    @include('dashboard.widgets.forms._class')
</x-widgets.forms.advanced>
