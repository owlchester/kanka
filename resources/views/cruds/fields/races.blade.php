@if (!$campaign->enabled('races'))
    <?php return ?>
@endif
<x-forms.field field="races">
    <input type="hidden" name="save_races" value="1">
    @include('components.form.races', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'quickCreator' => $quickCreator ?? false,
        'dynamicNew' => $dynamicNew ?? false
    ]])
</x-forms.field>
