@if (!$campaignService->enabled('organisations'))
    <?php return ?>
@endif

<input type="hidden" name="save_organisations" value="1">
<div class="field-organisations">
    @include('components.form.organisations', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'source' => $source ?? null,
    ]])
</div>
