<div class="tab-pane" id="form-ui">
    <p class="help-block">
        {{ __('campaigns.ui.helper') }}
    </p>

    <div class="row">
        <div class="col-sm-6">
            <label>{{ __('crud.fields.tooltip') }}</label>

            {!! Form::hidden('ui_settings[tooltip_family]', 0) !!}
            <div class="checkbox">
                <label>{!! Form::checkbox('ui_settings[tooltip_family]') !!}
                    {{ __('campaigns.fields.tooltip_family') }}
                </label>
            </div>

            <div class="checkbox">
            @if (isset($model) && $model->boosted())

                {!! Form::hidden('ui_settings[tooltip_image]', 0) !!}
                <label>{!! Form::checkbox('ui_settings[tooltip_image]') !!}
                    {{ __('campaigns.fields.tooltip_image') }}
                </label>
            @else
                <label>{!! Form::checkbox('ui_settings[tooltip_image]', null, false, ['disabled' => true]) !!}
                    {{ __('campaigns.fields.tooltip_image') }}
                    <span class="help-block">{!! __('campaigns.helpers.boost_required', [
                        'settings' => link_to_route('settings.boost', __('settings.menu.boost'))
                    ]) !!}</span>
                </label>
            @endif
            </div>
        </div>

        <div class="col-sm-6">
            <label>{{ __('campaigns.ui.other') }}</label>

            {!! Form::hidden('ui_settings[connections]', 0) !!}
            <div class="checkbox">
                <label>{!! Form::checkbox('ui_settings[connections]') !!}
                    {{ __('campaigns.fields.connections') }}
                </label>
            </div>

            {!! Form::hidden('ui_settings[nested]', 0) !!}
            <div class="checkbox">
                <label>{!! Form::checkbox('ui_settings[nested]') !!}
                    {{ __('campaigns.fields.nested') }}
                </label>
            </div>
        </div>
    </div>
</div>
