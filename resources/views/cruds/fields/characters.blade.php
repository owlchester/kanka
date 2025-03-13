@if (!$campaign->enabled('characters'))
    <?php return ?>
@endif

<div class="characters">
    <input type="hidden" name="save_characters" value="1">
    @include('components.form.characters', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'quickCreator' => $quickCreator ?? false,
        'dynamicNew' => $dynamicNew ?? false,
        'required'  => $required ?? false
    ]])
</div>
