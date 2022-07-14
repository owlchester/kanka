<div class="tab-pane" id="form-system">
    <p class="help-block">{{ __('campaigns.helpers.systems') }}</p>

    <div class="form-group">

        @include('components.form.rpg_systems', ['options' => [
            'model' => $model ?? null,
        ]])
    </div>
</div>
