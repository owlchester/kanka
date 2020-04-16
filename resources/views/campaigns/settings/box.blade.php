@if (isset($boosted) && $boosted && !$campaign->boosted())
    <div class="box box-solid box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="{{ $icon }}"></i> {{ __('entities.' . $module) }}
            </h3>
        </div>
        <div class="box-body">
            <p>{{ __('campaigns.settings.helpers.' . $module) }}</p>
        </div>
        <div class="box-footer checkbox text-center">
            <i>{!! __('campaigns.settings.boosted', ['boosted' => link_to_route('front.features', __('crud.boosted_campaigns'), '#boost')]) !!}</i>
        </div>
    </div>
@else
    <div class="box box-solid @if ($campaign->enabled($module)) box-success @else box-default @endif ">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="{{ $icon }}"></i> {{ __('entities.' . $module) }}
            </h3>
        </div>
        <div class="box-body">
            <p>{{ __('campaigns.settings.helpers.' . $module) }}</p>
        </div>
        <div class="box-footer checkbox text-center">
            {!! Form::hidden($module, 0) !!}
            <label>{!! Form::checkbox($module) !!}
                {{ __('campaigns.settings.actions.enable') }}
            </label>
        </div>
    </div>
@endif
