<x-grid type="1/1">
    @if (!isset($entityType))
        <x-helper>{{ __('campaigns/modules.create.helper') }}</x-helper>
    @endif

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
        'example' => '<code>fa-solid fa-flask-round-potion</code>',
        ])"
    >
        <input type="text" name="icon" value="{{ old('icon', $entityType->icon ?? '') }}" maxlength="40" placeholder="fa-solid fa-car" class="w-full" list="module-icon-list" autocomplete="off" data-paste="fontawesome" />
        <div class="hidden">
            <datalist id="module-icon-list">
                @foreach (\App\Facades\MapMarkerCache::iconSuggestion() as $icon)
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

    @endif

</x-grid>
