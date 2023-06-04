@php $boosted = $campaignService->campaign()->boosted() @endphp

<div class="nav-tabs-custom">
    <ul class="nav-tabs tabs-boxed">
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
            @include('cruds.fields.entity', [
    'required' => true, 'allowClear' => false, 'allowNew' => false,
    'route' => 'search.calendars'])

            <div class="row">
                <div class="col-sm-6">
                    @include('dashboard.widgets.forms._name')
                </div>
                <div class="col-sm-6">
                    @include('dashboard.widgets.forms._width')
                </div>
            </div>


            <div class="row">
                @includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')
            </div>
        </div>
        <div id="advanced" class="tab-pane fade in">
            @includeWhen(!$boosted, 'dashboard.widgets.forms._boosted')

            <div class="grid grid-cols-2 gap-2">
                @include('dashboard.widgets.forms._class')
            </div>
        </div>
    </div>
</div>
