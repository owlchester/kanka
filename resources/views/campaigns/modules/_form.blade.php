<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\EntityType $entityType
 */
?>
<x-grid type="1/1">
    <x-helper>
        <p>
            {{ __('campaigns/modules.rename.helper') }}
        </p>
    </x-helper>

    <x-forms.field
        field="status"
        :label="__('campaigns/modules.fields.status')"
        :helper="__('campaigns/modules.helpers.status')">
        <input type="hidden" name="enabled" value="0" />
        <x-checkbox :text="__('campaigns/modules.status.enabled')">
            <input type="checkbox" name="enabled" value="1" @if ($campaign->enabled($entityType)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    <hr />

    <x-forms.field
        field="singular"
        :label="__('campaigns/modules.fields.singular')"
        :helper="__('campaigns/modules.helpers.singular')">
        <input type="text" name="singular" value="{!! old('singular', $singular) !!}" maxlength="45" class="w-full" placeholder="{{ $entityType->name() }}" />
    </x-forms.field>

    <x-forms.field
        field="plural"
        :label="__('campaigns/modules.fields.plural')"
        :helper="__('campaigns/modules.helpers.plural')">
        <input type="text" name="plural" value="{!! old('plural', $plural) !!}" maxlength="45" class="w-full" placeholder="{{ $entityType->plural() }}" />
    </x-forms.field>

    <x-forms.field
        field="icon"
        :label="__('campaigns/modules.fields.icon')"
        :helper="__('campaigns/modules.helpers.icon', [
        'fontawesome' => '<a href=\'' . config('fontawesome.search') . '\'>FontAwesome</a>',
        'example' => '<i class=\'fa-solid fa-horse\' aria-hidden=\'true\'></i> <code>fa-solid fa-horse</code>',
        ])">
        <input type="text" name="icon" value="{{ old('icon', $icon) }}" maxlength="60" class="w-full" list="module-icon-list" placeholder="{{ $entityType->icon() }}" />
    </x-forms.field>

    @includeWhen(!$entityType->isBookmark(), 'cruds.fields.image-old', ['model' => $entityType ?? null, 'campaignImage' => true, 'imageLabel' => 'campaigns/modules.fields.image', 'isModule' => true, 'image' => isset($image) ? Img::crop(96, 96)->url($image['path']) : null])

</x-grid>
