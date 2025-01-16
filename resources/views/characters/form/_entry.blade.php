<x-grid>
    @include('cruds.fields.name', ['trans' => 'characters'])
    @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])
    @include('cruds.fields.title')
    @include('cruds.fields.families', ['quickCreator' => true])
    @include('cruds.fields.location')
    @include('cruds.fields.races', ['quickCreator' => true])
    @include('cruds.fields.entry2')

    <x-forms.field
        field="age"
        :label="__('characters.fields.age')"
        :helper="__('characters.helpers.age', ['more' => '<a href=\'https://docs.kanka.io/en/latest/advanced/age.html\' target=\'_blank\'>' . __('crud.actions.find_out_more') . '</a>'])">
        <input type="text" name="age" value="{{ old('age', FormCopy::field('age')->child()->string() ?: $model->age ?? null) }}" maxlength="25" class="w-full"  autocomplete="off" placeholder="{{ __('characters.placeholders.age') }}" />
    </x-forms.field>

    @include('cruds.fields.sex')

    @include('cruds.fields.pronouns')

    <x-forms.field
        field="dead"
        :label="__('characters.fields.is_dead')">
        <input type="hidden" name="is_dead" value="0" />
        <x-checkbox :text="__('characters.hints.is_dead')">
            <input type="checkbox" name="is_dead" value="1" @if (old('is_dead', FormCopy::field('is_dead')->child() ?? $model->is_dead ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.tags')

    @include('cruds.fields.image')
</x-grid>

@section('scripts')
    @parent
    @vite('resources/js/forms/character.js')
@endsection
