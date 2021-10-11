@php
$themes = [null => ''];
foreach (\App\Models\Theme::all() as $theme):
    $themes[$theme->id] = $theme->__toString();
endforeach;
@endphp

<div class="tab-pane" id="form-boosted">
    @include('cruds.partials.boosted')

    <div class="form-group">
        <label>{{ __('campaigns.fields.theme') }}</label>
        {!! Form::select(
            'theme_id',
            $themes,
            null,
            [
                'class' => 'form-control'
            ]
        ) !!}
        <p class="help-block">{{ __('campaigns.helpers.theme') }}</p>
    </div>

    @if (isset($campaign) && $campaign->id < 80000)
    <div class="form-group">
        <label>{{ __('campaigns.fields.css') }}</label>
        <div class="text-info">
            {!! __('campaigns/styles.helpers.css_moved', ['link' => link_to_route('campaign_styles.index', __('campaigns.show.tabs.styles'))]) !!}
        </div>
    </div>
    @endif

    <hr />
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::hidden('ui_settings[hide_members]', 0) !!}
                <label>{!! Form::checkbox('ui_settings[hide_members]', 1) !!}
                    {{ __('campaigns.fields.hide_members') }}
                </label>
                <p class="help-block">{{ __('campaigns.helpers.hide_members') }}</p>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::hidden('ui_settings[hide_history]', 0) !!}
                <label>{!! Form::checkbox('ui_settings[hide_history]', 1) !!}
                    {{ __('campaigns.fields.hide_history') }}
                </label>
                <p class="help-block">{{ __('campaigns.helpers.hide_history') }}</p>
            </div>
        </div>
    </div>
</div>
