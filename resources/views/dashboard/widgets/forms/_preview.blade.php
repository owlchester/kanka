@php $boosted = $campaign->boosted() @endphp
<x-grid>
    <div class="col-span-2">
        @include('cruds.fields.entity', ['required' => true])
    </div>

    @include('dashboard.widgets.forms._display')

    @include('dashboard.widgets.forms._name')

    @include('dashboard.widgets.forms._width')

    @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
</x-grid>



<x-widgets.forms.advanced>
    @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')

    <x-grid>
        @include('dashboard.widgets.forms._header_select')
        @include('dashboard.widgets.forms._related')
        @include('dashboard.widgets.forms._class')
    </x-grid>
</x-widgets.forms.advanced>
