<div class="box box-solid @if ($campaign->enabled($module)) box-success @else box-default @endif ">
    <div class="box-header with-border">
        <h3 class="box-title">
            <i class="{{ $icon }}"></i> {{ __('entities.' . $module) }}
        </h3>
    </div>
    <div class="box-body">
        <p>{{ trans('campaigns.settings.helpers.' . $module) }}</p>
    </div>
    <div class="box-footer checkbox text-center">
        {!! Form::hidden($module, 0) !!}
        <label>{!! Form::checkbox($module) !!}
            {{ trans('campaigns.settings.actions.enable') }}
        </label>
    </div>
</div>