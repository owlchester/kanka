@php $boosted = $campaign->boosted() @endphp
<x-grid type="1/1">
    @include('dashboard.widgets.forms._name')
    
    <div class="col-span-2">
        @include('cruds.fields.entity', [
'required' => true, 'allowClear' => false, 'allowNew' => false,
'route' => 'search.calendars'])
    </div>

    @include('dashboard.widgets.forms._width')

    @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
</x-grid>

<x-widgets.forms.advanced>
    @include('dashboard.widgets.forms._class')
</x-widgets.forms.advanced>
