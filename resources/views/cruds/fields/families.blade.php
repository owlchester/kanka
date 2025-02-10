@if (!$campaign->enabled('families'))
    <?php return ?>
@endif

<div class="families">
    <input type="hidden" name="save_families" value="1">
    @include('components.form.families', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'quickCreator' => $quickCreator ?? false,
        'dynamicNew' => $dynamicNew ?? false
    ]])
</div>
