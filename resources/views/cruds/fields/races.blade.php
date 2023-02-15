@if (!$campaign->enabled('races'))
    <?php return ?>
@endif
<input type="hidden" name="save_races" value="1">
<div class="form-group">
    @include('components.form.races', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'quickCreator' => $quickCreator ?? false
    ]])
</div>
