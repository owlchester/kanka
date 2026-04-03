<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])
    @include('cruds.fields.title')
    @include('cruds.fields.families', ['quickCreator' => true])
    @include('cruds.fields.locations', ['from' => $entity ?? null, 'quickCreator' => true, 'model' => $entity ?? $source ?? null])
    @include('cruds.fields.races', ['quickCreator' => true])
    @include('cruds.fields.entry2')
    @php
        $fieldID = uniqid('age_');
    @endphp
    <x-forms.field
        field="age"
        :label="__('characters.fields.age')"
        :helper="__('characters.helpers.age', ['more' => '<a href=\'https://docs.kanka.io/en/latest/advanced/age.html\' class=\'text-link\'>' . __('crud.actions.find_out_more') . '</a>'])"
        :id="$fieldID">
        <input id="{{ $fieldID }}" type="text" name="age" value="{{ old('age', FormCopy::field('age')->child()->string() ?: $model->age ?? null) }}" maxlength="25" class="w-full"  autocomplete="off" placeholder="{{ __('characters.placeholders.age') }}" />
    </x-forms.field>

    @include('cruds.fields.status')

    @include('cruds.fields.sex')

    @include('cruds.fields.pronouns')

    @include('cruds.fields.tags')

    @include('cruds.fields.image')
</x-grid>

@section('scripts')
    @parent
    @vite('resources/js/forms/character.js')
@endsection
