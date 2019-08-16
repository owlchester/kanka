<div class="tab-pane" id="form-system">
    <p class="help-block">{{ __('campaigns.helpers.systems') }}</p>

    <div class="form-group">
        {!! Form::rpg_systems(
            'rpg_system_id',
            [
                'model' => $model
            ]
        ) !!}
    </div>
</div>