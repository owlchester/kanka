<?php
$required = !isset($bulk);
$fieldID = uniqid('name_');

$endPoint = route('search-list', [$campaign, $entityType]);
$entityId = $entity->id ?? null;
$placeholder = __('entries/fields.name.placeholder');
// Entity names can contain ", ', emojis, & and other special characters
$modelValue = htmlspecialchars(old('name', str_replace('&amp;', '&', $model->name ?? '')));
$label = __('crud.fields.name');

// Existing aliases serialised for the Vue component (empty on create)
$entityAliasCount = isset($entity) && $entity->id ? $entity->aliases()->count() : 0;
$existingAliases = isset($entity) && $entity->id
    ? $entity->aliases()->get()->map(fn (\App\Models\EntityAsset $a) => [
        'id'         => $a->id,
        'name'       => $a->name,
        'visibility' => match ($a->visibility_id) {
            \App\Enums\Visibility::Admin => 'admin',
            \App\Enums\Visibility::AdminSelf => 'admin-self',
            \App\Enums\Visibility::Self => 'self',
            \App\Enums\Visibility::Member => 'members',
            default => 'all',
        },
    ])->toArray()
    : [];

// Compute effective alias limit for this entity's component.
// null = unlimited (boosted campaign), integer = remaining slots for this entity.
if ($campaign->boosted()) {
    $aliasLimit = null;
} else {
    $campaignAliasCount = $campaign->entityAliases()->count();
    $campaignMaxAliases = config('limits.campaigns.aliases');
    $aliasLimit = max(0, $campaignMaxAliases - $campaignAliasCount + $entityAliasCount);
}

$upgradeUrl = route('settings.premium');

$i18n = json_encode([
    'addAlias'          => __('entities/aliases.actions.add'),
    'aliasPlaceholder'  => __('entities/aliases.placeholders.name'),
    'duplicateWarning'  => __('entities.creator.duplicate'),
    'save'              => __('crud.save'),
    'delete'            => __('crud.remove'),
    'aliasLimitReached' => __('entities/aliases.limit', [
        'amount' => $campaignAliasCount ?? 0,
        'max' => config('limits.campaigns.aliases'),
        'upgrade' => '<a href="' . route('settings.premium') . '" class="font-extrabold">' . __('callouts.actions.upgrade') . '</a>'
    ]),
    'upgrade' => 'Upgrade to Premium',
    'visibilityAll'      => __('crud.visibilities.all'),
    'visibilityMembers'  => __('crud.visibilities.members'),
    'visibilityAdmin'    => __('crud.visibilities.admin'),
    'visibilityAdminSelf'=> __('crud.visibilities.admin-self'),
    'visibilitySelf'     => __('crud.visibilities.self'),
]);
?>

<div class="field-entity-name">
    <entity-name
        label="{{ $label }}"
        placeholder="{{ $placeholder }}"
        end-point="{{ $endPoint }}"
        entity-id="{{ $entityId }}"
        model-value="{{ $modelValue }}"
        :required="{{ $required ? 'true' : 'false' }}"
        aliases="{{ json_encode($existingAliases) }}"
        @if ($aliasLimit !== null) :alias-limit="{{ $aliasLimit }}" @else :alias-limit="null" @endif
        upgrade-url="{{ $upgradeUrl }}"
        i18n="{{ $i18n }}"
    ></entity-name>
</div>
