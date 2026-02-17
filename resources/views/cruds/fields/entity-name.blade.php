<?php
$required = !isset($bulk);
$fieldID = uniqid('name_');

$endPoint = route('search-list', [$campaign, $entityType]);
$entityId = $entity->id ?? null;
$placeholder = __('entries/fields.name.placeholder');
// Entity names can contain ", ', emojis, & and other special characters
$modelValue = htmlspecialchars(old('name', str_replace('&amp;', '&', $model->name ?? '')));
$label = __('crud.fields.name');
?>

<div class="field-entity-name">
    <entity-name
        label="{{ $label }}"
        placeholder="{{ $placeholder }}"
        endPoint="{{ $endPoint }}"
        entityId="{{ $entityId }}"
        modelValue="{{ $modelValue }}"
    ></entity-name>
</div>
