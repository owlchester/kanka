<div class="tab-pane" id="form-system">
    <x-helper :text="__('campaigns.helpers.systems')" />

    <div class="field-rpg">

        @include('components.form.rpg_systems', ['options' => [
            'model' => $model ?? null,
        ]])
    </div>
</div>
