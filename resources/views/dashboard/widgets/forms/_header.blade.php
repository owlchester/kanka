@php $boosted = $campaignService->campaign()->boosted() @endphp

<div class="nav-tabs-custom">
    <ul class="nav-tabs bg-base-300 !p-1 rounded" role="tablist">
        <li class="active">
            <a data-toggle="tab" href="#setup">
                {{ __('dashboard.widgets.tabs.setup') }}
            </a>
        </li>
        <li>
            <a class="" data-toggle="tab" href="#advanced">
                {{ __('dashboard.widgets.tabs.advanced') }}
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="setup" class="tab-pane fade in active">

            <x-grid>
                <div class="col-span-2">
                    @include('dashboard.widgets.forms._name')
                </div>

                @include('dashboard.widgets.forms._width')

                @include('dashboard.widgets.forms._size')

                @include('cruds.fields.entity', ['label' => __('dashboard.widgets.fields.optional-entity')])
            </x-grid>
        </div>
        <div id="advanced" class="tab-pane fade in">
            <x-grid>
                @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')

                @include('dashboard.widgets.forms._class')
            </x-grid>
        </div>
    </div>
</div>


