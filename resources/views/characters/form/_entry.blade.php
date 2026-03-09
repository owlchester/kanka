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

    <x-forms.field
        field="status_id"
        :label="__('characters.fields.status')">
        <select name="status_id" class="w-full">
            <option value="0" @selected(old('status_id', $source->child->status_id?->value ?? $model->status_id?->value ?? 0) == 0)>{{ __('characters.status.alive') }}</option>
            <option value="1" @selected(old('status_id', $source->child->status_id?->value ?? $model->status_id?->value ?? 0) == 1)>{{ __('characters.status.dead') }}</option>
            <option value="2" @selected(old('status_id', $source->child->status_id?->value ?? $model->status_id?->value ?? 0) == 2)>{{ __('characters.status.missing') }}</option>
        </select>
    </x-forms.field>

    @include('cruds.fields.sex')

    @include('cruds.fields.pronouns')

    @include('cruds.fields.tags')

    @include('cruds.fields.image')
</x-grid>

@section('scripts')
    @parent
    @vite('resources/js/forms/character.js')
@endsection
