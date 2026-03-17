<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])

    @include('cruds.fields.parent')

    <x-forms.field
        field="charges"
        :label="__('abilities.fields.charges')">
        <input type="text" name="charges" value="{!! htmlspecialchars(old('charges', $source->charges ?? $model->charges ?? null)) !!}" maxlength="191" class="w-full" placeholder="{{ __('abilities.placeholders.charges') }}" autocomplete="off" />
    </x-forms.field>
</x-grid>
