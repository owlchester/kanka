@if (!$campaign->enabled('locations'))
    <?php return ?>
@endif

<input type="hidden" name="save_locations" value="1">
<x-forms.field field="locations">
    @include('components.form.locations', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'source' => $source ?? null,
        'quickCreator' => $quickCreator ?? false
    ]])
</x-forms.field>
