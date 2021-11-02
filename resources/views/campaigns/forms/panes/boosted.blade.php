@php
$themes = [null => ''];
foreach (\App\Models\Theme::all() as $theme):
    $themes[$theme->id] = $theme->__toString();
endforeach;

$role = \App\Facades\CampaignCache::adminRole();
@endphp

<div class="tab-pane" id="form-boosted">
    @include('cruds.partials.boosted')

    <div class="row">
        <div class="col-sm-6">
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
        </div>
    </div>

    <hr />
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::hidden('ui_settings[hide_members]', 0) !!}
                <div class="checkbox">
                <label>{!! Form::checkbox('ui_settings[hide_members]', 1) !!}
                    {{ __('campaigns.fields.hide_members') }}
                </label>
                </div>
                <p class="help-block">
                    {!! __('campaigns.helpers.hide_members', [
    'admin' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')), null, ['target' => '_blank'])
]) !!}
                </p>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::hidden('ui_settings[hide_history]', 0) !!}
                <div class="checkbox">
                    <label>{!! Form::checkbox('ui_settings[hide_history]', 1) !!}
                        {{ __('campaigns.fields.hide_history') }}
                    </label>
                </div>

                <p class="help-block">
                    {!! __('campaigns.helpers.hide_history', [
    'admin' => link_to_route('campaigns.campaign_roles.admin', \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')), null, ['target' => '_blank'])
]) !!}
                </p>
            </div>
        </div>
    </div>
</div>
