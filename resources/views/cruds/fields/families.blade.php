@if (!$campaignService->enabled('families'))
    <?php return ?>
@endif
<div class="families form-group">
    <input type="hidden" name="save_families" value="1">
    @include('components.form.families', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'quickCreator' => $quickCreator ?? false
    ]])
</div>
