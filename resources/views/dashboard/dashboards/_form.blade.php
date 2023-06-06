<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignDashboard $dashboard
 */
?>
<div class="field-entity required">
    <label for="config-entity">
        {{ __('dashboard.dashboards.fields.name') }}
    </label>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('dashboard.dashboards.placeholders.name')]) !!}
</div>


<table class="table table-hover">
    <thead>
    <tr>
        <th>{{ __('campaigns.members.fields.role') }}</th>
        <th>{{ __('dashboard.dashboards.fields.visibility') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($campaign->roles as $role)
        <tr>
            <td>{{$role->name}}</td>
            <td>
                <select name="roles[{{ $role->id }}]" class="form-control">
                    @if(!$role->is_admin)
                    <option value="">{{ __('dashboard.dashboards.visibility.none') }}</option>
                    @endif

                    <option value="visible" @if(!empty($dashboard) && $dashboard->permission($role)) selected="selected" @endif>{{ __('dashboard.dashboards.visibility.visible') }}</option>
                    <option value="default" @if(!empty($dashboard) && $dashboard->permission($role, true)) selected="selected" @endif>{{ __('dashboard.dashboards.visibility.default') }}</option>
                </select>
            </td>
        </tr>
    @endforeach
    </tbody>

</table>


@if(!empty($source))
    <div class="field-copy">
        {!! Form::hidden('copy_widgets', null) !!}
        <label>{!! Form::checkbox('copy_widgets', 1, true) !!}
            {{ __('dashboard.dashboards.fields.copy_widgets') }}
        </label>
        <p class="help-block">{{ __('dashboard.dashboards.helpers.copy_widgets', ['name' => $source->name]) }}</p>
        {!! Form::hidden('source', $source->id) !!}
    </div>
@endif
