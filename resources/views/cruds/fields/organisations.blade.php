@if (!$campaign->enabled('organisations'))
    <?php return ?>
@endif

<input type="hidden" name="save_organisations" value="1">
<x-forms.field field="organisations">
    @include('components.form.organisations', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'source' => $source ?? null,
    ]])
</x-forms.field>
