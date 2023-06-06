@if (!$campaignService->enabled('locations'))
    <?php return ?>
@endif

<input type="hidden" name="save_locations" value="1">
<div class="field-locations">
    @include('components.form.locations', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'source' => $source ?? null,
        'quickCreator' => $quickCreator ?? false
    ]])
</div>
