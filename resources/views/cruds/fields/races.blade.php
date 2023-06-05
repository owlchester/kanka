@if (!$campaignService->enabled('races'))
    <?php return ?>
@endif
<div class="form-group races">
    <input type="hidden" name="save_races" value="1">
    @include('components.form.races', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'quickCreator' => $quickCreator ?? false
    ]])
</div>
