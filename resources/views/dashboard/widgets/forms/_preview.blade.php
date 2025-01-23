@php $boosted = $campaign->boosted() @endphp
<div class="nav-tabs-custom">
    <ul class="nav-tabs bg-base-300 !p-1 rounded" role="tablist">
        <li class="active">
            <a data-toggle="tab" href="#setup-{{ $mode }}">
                {{ __('dashboard.widgets.tabs.setup') }}
            </a>
        </li>
        <li>
            <a data-toggle="tab" href="#advanced-{{ $mode }}">
                {{ __('dashboard.widgets.tabs.advanced') }}
            </a>
        </li>
    </ul>

    <div class="tab-content p-4">
        <div id="setup-{{ $mode }}" class="tab-pane fade in active">

            <x-grid>
                <div class="col-span-2">
                    @include('cruds.fields.entity', ['required' => true])
                </div>

                @include('dashboard.widgets.forms._display')

                @include('dashboard.widgets.forms._name')

                @include('dashboard.widgets.forms._width')

                @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
            </x-grid>
        </div>
        <div id="advanced-{{ $mode }}" class="tab-pane fade in">
            @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')

            <x-grid>
                @include('dashboard.widgets.forms._header_select')
                @include('dashboard.widgets.forms._related')
                @include('dashboard.widgets.forms._class')
            </x-grid>
        </div>
    </div>
</div>
