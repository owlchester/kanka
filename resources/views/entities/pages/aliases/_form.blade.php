{{ csrf_field() }}

@if (!isset($entityAsset))

    <p class="text-neutral-content">
        {{ __('entities/aliases.helpers.primary') }}
    </p>
@endif

<x-grid>
    <x-forms.field field="name" required css="col-span-2" :label="__('entities/links.fields.name')">
        <input type="text" name="name" value="{!! htmlspecialchars(old('name', $entityAsset->name ?? null)) !!}" maxlength="45" class="w-full" placeholder="{{ __('entities/aliases.placeholders.name') }}" data-1p-ignore="true" />
    </x-forms.field>

    @include('cruds.fields.is_pinned', ['model' => $entityAsset ?? null, 'fieldName' => 'is_pinned'])
    @include('cruds.fields.visibility_id', ['model' => $entityAsset ?? null])
</x-grid>
<input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_ALIAS }}" />
