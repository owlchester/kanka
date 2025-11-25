<?php
/**
 * @var \App\Models\EntityType $entityType
 */
?>
<x-grid type="1/1">
    @if (!isset($entityType))
        <x-helper>
            <p>
                {{ __('campaigns/modules.create.helper') }}
            </p>
        </x-helper>
    @endif


    <x-forms.field
        field="status"
        :label="__('campaigns/modules.fields.status')"
        :helper="__('campaigns/modules.helpers.status')">
        <input type="hidden" name="is_enabled" value="0" />
        <x-checkbox :text="__('campaigns/modules.status.enabled')">
            <input type="checkbox" name="is_enabled" value="1" @if (old('enabled', $entityType?->isEnabled() ?? true)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    <hr />

    <x-forms.field
        field="singular"
        :label="__('campaigns/modules.fields.singular')"
        :helper="__('campaigns/modules.helpers.singular')"
    >
        <input type="text" name="singular" value="{!! old('singular', $entityType->singular ?? '') !!}" maxlength="45" class="w-full" placeholder="{{ '' }}" />
    </x-forms.field>

    <x-forms.field
        field="plural"
        :label="__('campaigns/modules.fields.plural')"
        :helper="__('campaigns/modules.helpers.plural')">
        <input type="text" name="plural" value="{!! old('plural', $entityType->plural ?? '') !!}" maxlength="45" class="w-full" placeholder="{{ '' }}" />
    </x-forms.field>

    <x-forms.field
        field="icon"
        :label="__('campaigns/modules.fields.icon')"
        :helper="__('campaigns/modules.helpers.icon', [
        'fontawesome' => '<a href=\'' . config('fontawesome.search') . '\'>FontAwesome</a>',
        'example' => '<i class=\'fa-solid fa-flask-round-potion\' aria-hidden=\'true\'></i>  <code>fa-solid fa-flask-round-potion</code>',
        ])"
    >
        <input type="text" name="icon" value="{{ old('icon', $entityType->icon ?? '') }}" maxlength="100" placeholder="fa-solid fa-car" class="w-full" list="module-icon-list" autocomplete="off" data-paste="fontawesome" />
        <div class="hidden">
            <datalist id="module-icon-list">
                @foreach (\App\Facades\MapMarkerCache::campaign($campaign)->iconSuggestion() as $icon)
                    <option value="{{ $icon }}">{{ $icon }}</option>
                @endforeach
            </datalist>
        </div>
    </x-forms.field>

    @if (!isset($entityType))
        <hr />


        <x-forms.field
            field="roles"
            :label="__('campaigns.members.fields.roles')"
            :helper="__('campaigns/modules.helpers.roles')"
        >
            @include('components.form.role', ['options' => [
                'dropdownParent' => '#primary-dialog',
                'multiple' => true,
            ]])
        </x-forms.field>
    @else
        <x-forms.field
            field="update-name">
            <input type="hidden" name="update_name" value="" />
            <x-checkbox :text="__('campaigns/modules.fields.update_name')">
                <input type="checkbox" name="update_name" value="1" checked="checked" />
            </x-checkbox>
        </x-forms.field>
    @endif

    @include('cruds.fields.image-old', ['model' => $entityType ?? null, 'campaignImage' => true, 'imageLabel' => 'campaigns.fields.image', 'recommended' => '240x208', 'isModule' => true, 'image' => isset($image) ? Img::crop(96, 96)->url($image['path']) : null])

</x-grid>
