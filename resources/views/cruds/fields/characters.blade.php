@if (!$campaign->enabled('characters'))
    <?php return ?>
@endif

<div class="characters">
    <input type="hidden" name="save_characters" value="1">
    @include('components.form.characters', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'dynamicNew' => $dynamicNew ?? $quickCreator ?? false,
        'required'  => $required ?? false
    ]])
</div>
