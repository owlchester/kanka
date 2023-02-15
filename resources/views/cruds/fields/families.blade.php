@if (!$campaign->enabled('families'))
    <?php return ?>
@endif
<input type="hidden" name="save_families" value="1">
<div class="form-group">
    @include('components.form.families', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'quickCreator' => $quickCreator ?? false
    ]])
</div>
